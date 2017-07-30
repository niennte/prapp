<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Add sequences to schema. 
 */
class Version20170730023858 extends AbstractMigration
{

    public function getDescription()
    {
        $description = 'Add sequences.';
        return $description;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $schema->createSequence("time_cards_seq");

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropSequence("time_cards_seq");

    }
}
