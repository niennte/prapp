<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

/**
 * Initial Schema
 */
class Version20170730010356 extends AbstractMigration
{

    public function getDescription()
    {
        $description = 'Create initial schema.';
        return $description;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        // TimeReport
        $table = $schema->createTable('time_reports');
        $table->addColumn('id', Type::INTEGER);
        $table->addColumn('date_filed', Type::DATE, ['notnull'=>true]);
        $table->setPrimaryKey(['id']);

        // TimeCard
        $table = $schema->createTable('time_cards');
        $table->addColumn('id', Type::INTEGER, ['autoincrement'=>true]);
        $table->addColumn('date', Type::DATE, ['notnull'=>true]);
        $table->addColumn('employee_id', Type::STRING , ['notnull'=>true, 'length'=>128]);
        $table->addColumn('hours_worked', Type::FLOAT, ['notnull'=>true]);
        $table->addColumn('job_group', Type::STRING, ['notnull'=>true, 'length'=>1]);
        $table->addColumn('job_group_effective_rate', Type::INTEGER, ['notnull'=>true]);
        $table->addColumn('time_report_id', Type::INTEGER, ['notnull'=>true]);
        $table->setPrimaryKey(['id']);

        // Payroll
        $table = $schema->createTable('payrolls');
        $table->addColumn('employee_id', Type::STRING , ['notnull'=>true, 'length'=>128]);
        $table->addColumn('pay_period_start_date', Type::DATE, ['notnull'=>true]);
        $table->addColumn('pay_period_end_date', Type::DATE, ['notnull'=>true]);
        $table->addColumn('total_hours', Type::FLOAT, ['notnull'=>true]);
        $table->addColumn('amount_paid', Type::FLOAT, ['notnull'=>true]);
        $table->addColumn('status', Type::STRING , ['notnull'=>true, 'length'=>128]);
        $table->setPrimaryKey(['employee_id', 'pay_period_start_date']);

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('time_reports');
        $schema->dropTable('time_cards');
        $schema->dropTable('payrolls');

    }
}
