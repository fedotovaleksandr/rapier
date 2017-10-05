<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171005164352 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE employee_days_event');
        $this->addSql('ALTER TABLE role RENAME COLUMN title TO role_name');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE employee_days_event (event_id INT NOT NULL, employee_day SMALLINT NOT NULL, PRIMARY KEY(event_id, employee_day))');
        $this->addSql('CREATE INDEX idx_8682eeda71f7e88b ON employee_days_event (event_id)');
        $this->addSql('CREATE INDEX idx_8682eedaec255f2d ON employee_days_event (employee_day)');
        $this->addSql('ALTER TABLE role RENAME COLUMN role_name TO title');
    }
}
