<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170926140420 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE employee_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE event_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE event_log_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE role_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE schedule_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE app_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE employee (id INT NOT NULL, user_id INT DEFAULT NULL, manager_id INT DEFAULT NULL, last_name VARCHAR(100) NOT NULL, first_name VARCHAR(100) NOT NULL, gender VARCHAR(1) NOT NULL, phone VARCHAR(50) NOT NULL, work_mode SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5D9F75A1A76ED395 ON employee (user_id)');
        $this->addSql('CREATE INDEX IDX_5D9F75A1783E3463 ON employee (manager_id)');
        $this->addSql('CREATE TABLE employee_role (employee_id INT NOT NULL, role_id INT NOT NULL, PRIMARY KEY(employee_id, role_id))');
        $this->addSql('CREATE INDEX IDX_E2B0C02D8C03F15C ON employee_role (employee_id)');
        $this->addSql('CREATE INDEX IDX_E2B0C02DD60322AC ON employee_role (role_id)');
        $this->addSql('CREATE TABLE employee_day (day SMALLINT NOT NULL, employee_id INT NOT NULL, start_time TIME(0) WITHOUT TIME ZONE DEFAULT NULL, end_time TIME(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(employee_id, day))');
        $this->addSql('CREATE INDEX IDX_EC255F2D8C03F15C ON employee_day (employee_id)');
        $this->addSql('CREATE TABLE event (id INT NOT NULL, employee_id INT DEFAULT NULL, schedule_id INT NOT NULL, role_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(4000) DEFAULT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, duration INT NOT NULL, period SMALLINT NOT NULL, importance SMALLINT NOT NULL, status SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3BAE0AA78C03F15C ON event (employee_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7A40BC2D5 ON event (schedule_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7D60322AC ON event (role_id)');
        $this->addSql('CREATE TABLE event_day (day SMALLINT NOT NULL, event_id INT NOT NULL, PRIMARY KEY(event_id, day))');
        $this->addSql('CREATE INDEX IDX_F46FEC4371F7E88B ON event_day (event_id)');
        $this->addSql('CREATE TABLE event_log (id INT NOT NULL, employee_id INT NOT NULL, event_id INT NOT NULL, time_instant TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(4000) DEFAULT NULL, action SMALLINT NOT NULL, start_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, duration INT NOT NULL, old_status SMALLINT DEFAULT NULL, new_status SMALLINT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9EF0AD168C03F15C ON event_log (employee_id)');
        $this->addSql('CREATE INDEX IDX_9EF0AD1671F7E88B ON event_log (event_id)');
        $this->addSql('CREATE TABLE role (id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(4000) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE schedule (id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(4000) DEFAULT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE app_user (id INT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, roles TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E992FC23A8 ON app_user (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9A0D96FBF ON app_user (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_88BDF3E9C05FB297 ON app_user (confirmation_token)');
        $this->addSql('COMMENT ON COLUMN app_user.roles IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1783E3463 FOREIGN KEY (manager_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE employee_role ADD CONSTRAINT FK_E2B0C02D8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE employee_role ADD CONSTRAINT FK_E2B0C02DD60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE employee_day ADD CONSTRAINT FK_EC255F2D8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA78C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7A40BC2D5 FOREIGN KEY (schedule_id) REFERENCES schedule (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7D60322AC FOREIGN KEY (role_id) REFERENCES role (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_day ADD CONSTRAINT FK_F46FEC4371F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_log ADD CONSTRAINT FK_9EF0AD168C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
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
        $this->addSql('ALTER TABLE employee DROP CONSTRAINT FK_5D9F75A1783E3463');
        $this->addSql('ALTER TABLE employee_role DROP CONSTRAINT FK_E2B0C02D8C03F15C');
        $this->addSql('ALTER TABLE employee_day DROP CONSTRAINT FK_EC255F2D8C03F15C');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA78C03F15C');
        $this->addSql('ALTER TABLE event_log DROP CONSTRAINT FK_9EF0AD168C03F15C');
        $this->addSql('ALTER TABLE event_day DROP CONSTRAINT FK_F46FEC4371F7E88B');
        $this->addSql('ALTER TABLE event_log DROP CONSTRAINT FK_9EF0AD1671F7E88B');
        $this->addSql('ALTER TABLE employee_role DROP CONSTRAINT FK_E2B0C02DD60322AC');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA7D60322AC');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA7A40BC2D5');
        $this->addSql('ALTER TABLE employee DROP CONSTRAINT FK_5D9F75A1A76ED395');
        $this->addSql('DROP SEQUENCE employee_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE event_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE event_log_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE role_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE schedule_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE app_user_id_seq CASCADE');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE employee_role');
        $this->addSql('DROP TABLE employee_day');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_day');
        $this->addSql('DROP TABLE event_log');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE app_user');
    }
}
