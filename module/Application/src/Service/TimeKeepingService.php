<?php
namespace Application\Service;

use Application\Entity\TimeCard;
use Application\Model\TimeReport;
use Application\Model\Factory\TimeReportFactory;
use Doctrine\ORM\EntityManager;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

use Exception;


/**
 * Class responsible for coordinating time keeping data flow.
 */
class TimeKeepingService
{
    /**
     * Entity manager.
     * Dependency-injected by the factory called by framework's service manager.
     */
    private $entityManager;

    /**
     * Constructor.
     *
     * @param $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param mixed $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @var
     */
    private $serviceWarnings;

    /**
     * @var
     */
    private $serviceErrors;

    /**
     *
     * CSV Upload handler
     * Parse the CSV and load into the model
     *
     * @param $csvUpload
     */
    public function handleTimeReportUpload($csvUpload) {
        try {
            $timeReport = TimeReportFactory::constructFromCsv($csvUpload, $this->entityManager);
        } catch (Exception $e) {
            $this->setServiceErrors($e->getMessage());
            return;
        }
        $this->handleSaveTimeReport($timeReport);
    }

    /**
     *
     * Report save handler
     * Validate models and save data.
     */
    public function handleSaveTimeReport(TimeReport $timeReport) {
        if ($timeReport->isValid()) {
            $timeReport->save();
        } else {
            $this->setServiceErrors($timeReport->getErrors());
        }
        $this->setServiceWarnings($timeReport->getWarnings());
    }


    /**
     * Stub.
     *
     */
    public function getPayrollReport($page, $pageSize) {

        $repository = $this->entityManager->getRepository(TimeCard::class);
        $query = $repository->fetchPayrollsForPagination();
        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage($pageSize);
        $paginator->setCurrentPageNumber($page);

        return $paginator;
    }

    /**
     * @return mixed
     */
    public function getServiceWarnings()
    {
        return $this->serviceWarnings;
    }

    /**
     * @param mixed $serviceWarnings
     */
    public function setServiceWarnings($serviceWarnings)
    {
        $this->serviceWarnings = $serviceWarnings;
    }

    /**
     * @return mixed
     */
    public function getServiceErrors()
    {
        return $this->serviceErrors;
    }

    /**
     * @param mixed $serviceErrors
     */
    public function setServiceErrors($serviceErrors)
    {
        $this->serviceErrors = $serviceErrors;
    }

    /**
     * Stub
     * @return bool
     */
    public function hasErrors()
    {
        return !empty($this->getServiceErrors());
    }

    /**
     * Stub
     * @return bool
     */
    public function hasWarnings()
    {
        return !empty($this->getServiceWarnings());
    }
}