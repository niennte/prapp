<?php
namespace Application\Repository;

use Application\Entity\TimeKeepingDataRecord;
use Application\Model\TimeCard;
use Doctrine\ORM\EntityRepository;

/**
 * Class TimeKeepingRepository
 * Repository for entity TimeKeepingData.
 *
 * @package Application\Repository
 */
class TimeKeepingRepository extends EntityRepository
{
    /**
     * Compose a payroll report query for the paginator.
     */
    public function fetchPayrollReportQuery()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        $queryBuilder
            ->select('data')
            ->addSelect('SUM(data.hoursWorked)*data.jobGroupEffectiveRate as amount_paid')
            ->from(TimeKeepingDataRecord::class, 'data')
            ->groupBy('data.employeeId')
            ->addGroupBy('data.jobGroupEffectiveRate')
            ->addGroupBy('data.payPeriodStartDate')
            ->orderBy('data.employeeId')
            ->addOrderBy('data.payPeriodStartDate');

        return $queryBuilder->getQuery();
    }

    /**
     * @param $timeReportId
     *
     * @return bool
     */
    public function fetchTimeReportIsUnique($timeReportId) {

        $queryBuilder = $this->getEntityManager()->createQueryBuilder();

        $result = $queryBuilder
            ->select('count(data.timeReportId)')
            ->from(TimeKeepingDataRecord::class, 'data')
            ->where('data.timeReportId = ?1')
            ->setParameter('1', (int) $timeReportId)
            ->getQuery()
            ->getSingleScalarResult();

        return 0 === (int)$result;
    }

    /**
     *
     * @param TimeCard $timeCard
     */
    public function saveTimeCard(TimeCard $timeCard)
    {
        $timeCardEntity = TimeKeepingDataRecord::fromModel($timeCard);
        $this->getEntityManager()->persist($timeCardEntity);
        $this->getEntityManager()->flush();
    }
}