<?php

namespace Application\Model;

use Application\Repository\TimeKeepingRepository;
use Doctrine\ORM\EntityManager;

use Exception;


/**
 * Class TimeReport
 * Wrapper model representing a batch of TimeCard records.
 *
 * @package Application\Model
 *
 */

class TimeReport
{
    /**
     * @var
     */
    protected $reportId;
    private $timeCards;
    private $errors;
    private $warnings;

    private $entityManager;

    /**
     * TimeReport constructor.
     *
     * @param $reportId
     * @param $records
     * @param EntityManager|null $entityManager
     */
    public function __construct($reportId, $records, EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
        $this->errors = [];
        $this->warnings = [];

        $this->reportId = $reportId;

        if (is_array($records)) {
            foreach ($records as $row) {
                $timeCard = new TimeCard();
                $timeCard->exchangeArray($row);
                $timeCard->setTimeReportId($reportId);

                // Skip invalid models before hitting repository
                if ($error = $timeCard->getErrors()) {
                    $this->setWarnings('Skipping record(s): ' . $error);
                    continue;
                }

                $this->timeCards[] = $timeCard;
            }
        }
    }

    public function save() {
        $repository = $this->entityManager->getRepository(\Application\Entity\TimeReport::class);
        try {
            if ($repository instanceof TimeKeepingRepository) {
                $repository->saveTimeReport($this);
            }
        } catch (Exception $e) {
            $this->setErrors($e->getMessage());
        }
    }

    private function validate() {
        if (!$this->getReportId() > 0) {
            $this->setErrors("Error: Time report must have a valid id.");
            return;
        }

        if (!count($this->getTimeCards()) ) {
            $this->setErrors('Error: Time report has no valid records.');
            return;
        }

        if (!$this->isUnique()) {
            $this->setErrors(
                'Error: Time Report with ID '
                . $this->getReportId()
                .' already exists.'
            );
        }
    }

    public function isValid() {
        $this->validate();
        /**
         * Stub
         */
        return count($this->errors) === 0;
    }


    public function isUnique() {
        $repository = $this->entityManager->getRepository(\Application\Entity\TimeCard::class);
        return $repository->fetchTimeReportIsUnique($this->getReportId());
    }


    /**
     * @return mixed
     */
    public function getReportId()
    {
        return $this->reportId;
    }

    /**
     * @param mixed $reportId
     *
     * @return TimeReport
     */
    public function setReportId($reportId)
    {
        $this->reportId = $reportId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimeCards()
    {
        return $this->timeCards;
    }

    /**
     * @param mixed $timeCards
     *
     * @return TimeReport
     */
    public function setTimeCards($timeCards)
    {
        $this->timeCards = $timeCards;
        return $this;
    }

    /**
     * @param mixed $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public final function getEntityManager()
    {
        throw new Exception("Please set the entity manager from the service.");
    }


    /**
     * @return mixed
     */
    public function getErrors()
    {
        return is_array($this->warnings) ? array_pop($this->errors) : null;
    }

    /**
     * @param $errors
     */
    public function setErrors($errors)
    {
        $this->errors[] = $errors;
    }

    /**
     * Stub
     * @return mixed
     */
    public function getWarnings()
    {
        return is_array($this->warnings) ? array_pop($this->warnings) : null;
    }

    /**
     * @param $errors
     */
    public function setWarnings($warnings)
    {
        $this->warnings[] = $warnings;
    }




}