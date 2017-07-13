<?php

namespace Application\Model\Factory;


use Application\Model\TimeReport;
use Doctrine\ORM\EntityManager;
use SplFileObject;
use Exception;

class TimeReportFactory
{

    public $errors;
    /**
     *
     * Construct an instance of TimeReport populated from a CSV file.
     * Pass entity manager to the constructor
     *
     * @param $CSV
     * @param EntityManager|null $entityManager
     *
     * @return TimeReport
     * @throws Exception
     * @internal param EntityManager|null $entityManager
     */
    public static function constructFromCsv($CSV, EntityManager $entityManager) {

        $self = new static;
        $self->errors = null;
        $data = $self->readCsv($CSV);
        $timeReport = new TimeReport(
            $data['reportId'], $data['records'], $entityManager
        );
        if ($self->errors) {
            $timeReport->setErrors($self->errors);
        }

        return $timeReport;
    }

    public function readCsv($CSV) {

        $reportId = null;
        $records = [];

        try {
            $file = new SplFileObject($CSV);

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
                    $this->errors = "Error: CSV not well formed.";
                    break;
                }

                $records[] = array_combine($CSVHeaders, $row);
            }

            $CSVFooter = array_pop($records);
            $reportId = (int) array_values($CSVFooter)[1];
        } catch (Exception $e) {
            $this->errors = "Error: " . $e->getMessage();
        }

        return [
            'reportId' => $reportId,
            'records' => $records,
        ];
    }
}