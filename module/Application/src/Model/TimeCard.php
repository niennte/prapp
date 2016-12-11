<?php

namespace Application\Model;

use Application\Service\RateService;
use Application\Service\PayPeriodService;
use Zend\Stdlib\ArrayObject;

/**
 * Class TimeCard
 * Responsible for flat sets of well formed data
 * communicated between data store and models
 *
 * @package Application\Model
 */
class TimeCard extends AbstractSelfMappingModel
{
    protected $id;
    protected $date;
    protected $employeeId;
    protected $hoursWorked;
    protected $jobGroup;
    protected $timeReportId;
    protected $payPeriodStartDate;
    protected $payPeriodEndDate;
    protected $jobGroupEffectiveRate;

    private $payPeriodService;
    private $rateService;

    public function __construct() {
        $this->payPeriodService = new PayPeriodService();
        $this->rateService = new RateService();
    }

    /**
     * @param mixed $timeReportId
     */
    public function setTimeReportId($timeReportId)
    {
        $this->timeReportId = $timeReportId;
    }

    /**
     *
     * Combine incoming data.
     *
     * @param $data
     * @return void|static
     */
    public function exchangeArray($data) {

        // populate with data from input
        parent::exchangeArray($data);

        // add data from other services
        $this->payPeriodStartDate = $this->payPeriodService->getStartDate($data['date']);
        $this->payPeriodEndDate = $this->payPeriodService->getEndDate($data['date']);
        $this->jobGroupEffectiveRate = $this->rateService->getForGroup($data['job_group']);
    }

    /**
     * Stub
     * Place to reformat data on the way out
     * @return array
     */
    public function getArrayCopy() {

        // parent's method will keep data as expected by data store
        return parent::toArray();
    }

    /**
     *
     * Stub.
     * Checks for nulls in data
     * Error propagates into container model as a warning
     *
     * @return bool|string
     */
    public function getErrors() {

        $fields = parent::toArray();
        unset($fields['id']);
        $key = array_search(null, $fields);
        return $key ? "Field $key cannot be null.": false;

    }

    /**
     *
     * Stub.
     * Checks for nulls in data
     * Error propagates into container model as a warning
     *
     * @return bool|string
     */
    public function isValid() {

        $fields = parent::toArray();
        unset($fields['id']);
        $key = array_search(null, $fields);
        return $key ? false : true;

    }

}