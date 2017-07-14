<?php
namespace Application\Repository;

use Application\Entity\TimeReport as TimeReportEntity;
use Application\Entity\Payroll as PayrollEntity;
use Application\Entity\TimeCard as TimeCardEntity;
use Application\Model\TimeReport;
use Application\Model\TimeCard;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;


/**
 * Class TimeKeepingRepository
 *
 * @package Application\Repository
 */
class TimeKeepingRepository extends EntityRepository
{

    public function fetchPayrollsForPagination()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        $queryBuilder
            ->select(['p'])
            ->from(PayrollEntity::class, 'p')
            ->addOrderBy('p.employeeId')
            ->addOrderBy('p.payPeriodStartDate');

        return $queryBuilder->getQuery();
    }

    /**
     * @param $timeReportId
     *
     * @return bool
     */
    public function fetchTimeReportIsUnique($timeReportId) {

        return null === $this
                ->getEntityManager()
                ->getRepository(TimeReportEntity::class)
                ->find($timeReportId);
    }

    public function saveTimeReport(TimeReport $timeReport)
    {
        /*
         * EntityManager::transactional()
         * wraps contents of clusire into a transaction,
         * commits on success,
         * rolls back with an exception on failure
         */
        $this->getEntityManager()->transactional(
            function(EntityManager $em) use ($timeReport) {

                // Save time report
                $timeReportEntity = new TimeReportEntity();

                $timeReportEntity
                ->setId($timeReport->getReportId())
                ->setDateFiled(date ('Y-m-d', (strtotime('now'))));

                $em->persist($timeReportEntity);

                // Save time cards
                foreach($timeReport->getTimeCards() as $timeCard) {

                    $timeCardEntity = TimeCardEntity::fromModel($timeCard)
                        ->setTimeReport($timeReportEntity);

                    if ($timeCard instanceof TimeCard) {

                        // Build and populate payroll model
                        $payroll = $timeCard->addToPayroll()->getPayroll();

                        // Look for existing entity, create if not found
                        if (
                            $payrollEntity = $em
                            ->getRepository(PayrollEntity::class)
                            ->find([
                                'employeeId' => $payroll->getEmployeeId(),
                                'payPeriodStartDate' => $payroll->getPayPeriodStartDate()
                            ])
                        ) {
                            $payrollEntity
                                ->setTotalHours(
                                    $payrollEntity->getTotalHours() + $payroll->getTotalHours()
                                )
                                ->setAmountPaid(
                                    $payrollEntity->getAmountPaid() + $payroll->getAmountPaid()
                                );
                        } else {
                            $payrollEntity = PayrollEntity::fromModel($payroll);
                        }

                        $em->persist($payrollEntity);
                        $em->persist($timeCardEntity);
                    }
                }
            }
        );
    }

}