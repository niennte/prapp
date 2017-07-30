<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Add relationships and indexes to schema.
 */
class Version20170730023335 extends AbstractMigration
{

    public function getDescription()
    {
        $description = 'Add indexes and foreign keys.';
        return $description;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->getTable('time_cards');
        $table->addIndex(['time_report_id'], 'time_report_id_index');
        $table->addForeignKeyConstraint(
            'time_reports',
            ['time_report_id'],
            ['id'],
            ["onDelete" => "CASCADE",
             'time_report_id_fk']
        );

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $table = $schema->getTable('time_cards');
        $table->dropIndex('time_report_id_index');
        $table->removeForeignKey("time_report_id_fk");

    }
}
