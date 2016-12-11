<?php

namespace Application\Model;

use Doctrine\ORM\EntityManager;
use Application\Entity\TimeKeepingDataRecord;

use Exception;
use SplFileObject;


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
    private $reportId;
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


    /**
     *
     * Construct an instance of self populated from a CSV file.
     * Pass entity manager to the constructor
     *
     * @param $CSV
     * @param EntityManager|null $entityManager
     * @return static
     * @throws Exception
     * @internal param EntityManager|null $entityManager
     */
    public static function fromCsv($CSV, EntityManager $entityManager) {

        try {
            $file = new SplFileObject($CSV);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }

        $file->setFlags(
            SplFileObject::READ_CSV |
            SplFileObject::SKIP_EMPTY |
            SplFileObject::READ_AHEAD
        );
        $CSVHeaders = null;
        foreach ($file as $row) {
            if ($CSVHeaders === null) {
                $CSVHeaders = $row;
                $CSVHeaders = str_replace(" ", "_", $CSVHeaders);
                continue;
            }

            if (count($CSVHeaders) != count($row)) {
                throw new Exception("Error: CSV not well formed.");
            }
            $records[] = array_combine($CSVHeaders, $row);
        }

        $CSVFooter = array_pop($records);
        $reportId = (int) array_values($CSVFooter)[1];

        return new static($reportId, $records, $entityManager);
    }

    public function save() {
        $repository = $this->entityManager->getRepository(TimeKeepingDataRecord::class);
        foreach ($this->getTimeCards() as $record) {
            $repository->saveTimeCard($record);
        }
    }

    private function validate() {
        if (!$this->getReportId() > 0) {
            $this->setErrors("Error: Report must have a valid id.");
            return;
        }

        if (!count($this->getTimeCards()) ) {
            $this->setErrors('Error: Report has no valid records.');
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
        $repository = $this->entityManager->getRepository(TimeKeepingDataRecord::class);
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
        return array_pop($this->errors);
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
        return array_pop($this->warnings);
    }

    /**
     * @param $errors
     */
    public function setWarnings($warnings)
    {
        $this->warnings[] = $warnings;
    }




}