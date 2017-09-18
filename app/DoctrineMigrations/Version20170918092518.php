<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170918092518 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE employee_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE schedule_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE event_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE role_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE event_log_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE employee (id INT NOT NULL, parent_id INT DEFAULT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, gender SMALLINT NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, work_mode SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5D9F75A1727ACA70 ON employee (parent_id)');
        $this->addSql('CREATE TABLE employee_role (employee_id INT NOT NULL, role_id INT NOT NULL, PRIMARY KEY(employee_id, role_id))');
        $this->addSql('CREATE INDEX IDX_E2B0C02D8C03F15C ON employee_role (employee_id)');
        $this->addSql('CREATE INDEX IDX_E2B0C02DD60322AC ON employee_role (role_id)');
        $this->addSql('CREATE TABLE schedule (id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE event (id INT NOT NULL, employee_id INT DEFAULT NULL, schedule_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, interval CHAR(255) NOT NULL, importance SMALLINT NOT NULL, status SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3BAE0AA78C03F15C ON event (employee_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7A40BC2D5 ON event (schedule_id)');
        $this->addSql('COMMENT ON COLUMN event.interval IS \'(DC2Type:dateinterval)\'');
        $this->addSql('CREATE TABLE employee_days_event (event_id INT NOT NULL, employee_day SMALLINT NOT NULL, PRIMARY KEY(event_id, employee_day))');
        $this->addSql('CREATE INDEX IDX_8682EEDA71F7E88B ON employee_days_event (event_id)');
        $this->addSql('CREATE INDEX IDX_8682EEDAEC255F2D ON employee_days_event (employee_day)');
        $this->addSql('CREATE TABLE employee_day (day SMALLINT NOT NULL, employee_id INT DEFAULT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(day))');
        $this->addSql('CREATE INDEX IDX_EC255F2D8C03F15C ON employee_day (employee_id)');
        $this->addSql('CREATE TABLE role (id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE event_log (id INT NOT NULL, event_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, action SMALLINT NOT NULL, interval CHAR(255) NOT NULL, old_status SMALLINT NOT NULL, new_status SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9EF0AD1671F7E88B ON event_log (event_id)');
        $this->addSql('COMMENT ON COLUMN event_log.interval IS \'(DC2Type:dateinterval)\'');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1727ACA70 FOREIGN KEY (parent_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE employee_role ADD CONSTRAINT FK_E2B0C02D8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE employee_role ADD CONSTRAINT FK_E2B0C02DD60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA78C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7A40BC2D5 FOREIGN KEY (schedule_id) REFERENCES schedule (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE employee_days_event ADD CONSTRAINT FK_8682EEDA71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE employee_days_event ADD CONSTRAINT FK_8682EEDAEC255F2D FOREIGN KEY (employee_day) REFERENCES employee_day (day) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE employee_day ADD CONSTRAINT FK_EC255F2D8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_log ADD CONSTRAINT FK_9EF0AD1671F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE employee DROP CONSTRAINT FK_5D9F75A1727ACA70');
        $this->addSql('ALTER TABLE employee_role DROP CONSTRAINT FK_E2B0C02D8C03F15C');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA78C03F15C');
        $this->addSql('ALTER TABLE employee_day DROP CONSTRAINT FK_EC255F2D8C03F15C');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA7A40BC2D5');
        $this->addSql('ALTER TABLE employee_days_event DROP CONSTRAINT FK_8682EEDA71F7E88B');
        $this->addSql('ALTER TABLE event_log DROP CONSTRAINT FK_9EF0AD1671F7E88B');
        $this->addSql('ALTER TABLE employee_days_event DROP CONSTRAINT FK_8682EEDAEC255F2D');
        $this->addSql('ALTER TABLE employee_role DROP CONSTRAINT FK_E2B0C02DD60322AC');
        $this->addSql('DROP SEQUENCE employee_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE schedule_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE event_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE role_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE event_log_id_seq CASCADE');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE employee_role');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE employee_days_event');
        $this->addSql('DROP TABLE employee_day');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE event_log');
    }
}
