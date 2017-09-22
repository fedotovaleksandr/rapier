<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170922140838 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE employee_days_event');
        $this->addSql('ALTER TABLE employee DROP CONSTRAINT fk_5d9f75a1727aca70');
        $this->addSql('DROP INDEX idx_5d9f75a1727aca70');
        $this->addSql('ALTER TABLE employee ADD manager_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE employee DROP email');
        $this->addSql('ALTER TABLE employee ALTER last_name TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE employee ALTER first_name TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE employee ALTER phone TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE employee RENAME COLUMN parent_id TO user_id');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1783E3463 FOREIGN KEY (manager_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5D9F75A1A76ED395 ON employee (user_id)');
        $this->addSql('CREATE INDEX IDX_5D9F75A1783E3463 ON employee (manager_id)');
        //$this->addSql('DROP INDEX "primary"');
        $this->addSql('ALTER TABLE employee_day ADD start_time TIME(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE employee_day ADD end_time TIME(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE employee_day DROP start_date');
        $this->addSql('ALTER TABLE employee_day DROP end_date');
        $this->addSql('ALTER TABLE employee_day ALTER employee_id SET NOT NULL');
        $this->addSql('ALTER TABLE employee_day DROP CONSTRAINT employee_day_pkey');
        $this->addSql('ALTER TABLE employee_day ADD PRIMARY KEY (employee_id, day)');
        $this->addSql('ALTER TABLE event ADD role_id INT NOT NULL');
        $this->addSql('ALTER TABLE event ADD duration INT NOT NULL');
        $this->addSql('ALTER TABLE event DROP "interval"');
        $this->addSql('ALTER TABLE event ALTER schedule_id SET NOT NULL');
        $this->addSql('ALTER TABLE event ALTER description DROP NOT NULL');
        $this->addSql('ALTER TABLE event ALTER description TYPE VARCHAR(4000)');
        $this->addSql('ALTER TABLE event ALTER start_date DROP NOT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7D60322AC FOREIGN KEY (role_id) REFERENCES role (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7D60322AC ON event (role_id)');
        $this->addSql('ALTER TABLE event_log ADD employee_id INT NOT NULL');
        $this->addSql('ALTER TABLE event_log ADD start_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE event_log ADD duration INT NOT NULL');
        $this->addSql('ALTER TABLE event_log DROP "interval"');
        $this->addSql('ALTER TABLE event_log ALTER event_id SET NOT NULL');
        $this->addSql('ALTER TABLE event_log ALTER description DROP NOT NULL');
        $this->addSql('ALTER TABLE event_log ALTER description TYPE VARCHAR(4000)');
        $this->addSql('ALTER TABLE event_log ALTER old_status DROP NOT NULL');
        $this->addSql('ALTER TABLE event_log ALTER new_status DROP NOT NULL');
        $this->addSql('ALTER TABLE event_log RENAME COLUMN start_date TO time_instant');
        $this->addSql('ALTER TABLE event_log ADD CONSTRAINT FK_9EF0AD168C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9EF0AD168C03F15C ON event_log (employee_id)');
        $this->addSql('ALTER TABLE role ALTER description DROP NOT NULL');
        $this->addSql('ALTER TABLE role ALTER description TYPE VARCHAR(4000)');
        $this->addSql('ALTER TABLE schedule ALTER description DROP NOT NULL');
        $this->addSql('ALTER TABLE schedule ALTER description TYPE VARCHAR(4000)');
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
        $this->addSql('ALTER TABLE employee_days_event ADD CONSTRAINT fk_8682eeda71f7e88b FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE employee_days_event ADD CONSTRAINT fk_8682eedaec255f2d FOREIGN KEY (employee_day) REFERENCES employee_day (day) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA7D60322AC');
        $this->addSql('DROP INDEX IDX_3BAE0AA7D60322AC');
        $this->addSql('ALTER TABLE event ADD "interval" CHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE event DROP role_id');
        $this->addSql('ALTER TABLE event DROP duration');
        $this->addSql('ALTER TABLE event ALTER schedule_id DROP NOT NULL');
        $this->addSql('ALTER TABLE event ALTER description SET NOT NULL');
        $this->addSql('ALTER TABLE event ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE event ALTER start_date SET NOT NULL');
        $this->addSql('COMMENT ON COLUMN event."interval" IS \'(DC2Type:dateinterval)\'');
        $this->addSql('DROP INDEX employee_day_pkey');
        $this->addSql('ALTER TABLE employee_day ADD start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE employee_day ADD end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE employee_day DROP start_time');
        $this->addSql('ALTER TABLE employee_day DROP end_time');
        $this->addSql('ALTER TABLE employee_day ALTER employee_id DROP NOT NULL');
        $this->addSql('ALTER TABLE employee_day ADD PRIMARY KEY (day)');
        $this->addSql('ALTER TABLE event_log DROP CONSTRAINT FK_9EF0AD168C03F15C');
        $this->addSql('DROP INDEX IDX_9EF0AD168C03F15C');
        $this->addSql('ALTER TABLE event_log ADD "interval" CHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE event_log DROP employee_id');
        $this->addSql('ALTER TABLE event_log DROP start_time');
        $this->addSql('ALTER TABLE event_log DROP duration');
        $this->addSql('ALTER TABLE event_log ALTER event_id DROP NOT NULL');
        $this->addSql('ALTER TABLE event_log ALTER description SET NOT NULL');
        $this->addSql('ALTER TABLE event_log ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE event_log ALTER old_status SET NOT NULL');
        $this->addSql('ALTER TABLE event_log ALTER new_status SET NOT NULL');
        $this->addSql('ALTER TABLE event_log RENAME COLUMN time_instant TO start_date');
        $this->addSql('COMMENT ON COLUMN event_log."interval" IS \'(DC2Type:dateinterval)\'');
        $this->addSql('ALTER TABLE schedule ALTER description SET NOT NULL');
        $this->addSql('ALTER TABLE schedule ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE role ALTER description SET NOT NULL');
        $this->addSql('ALTER TABLE role ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE employee DROP CONSTRAINT FK_5D9F75A1A76ED395');
        $this->addSql('ALTER TABLE employee DROP CONSTRAINT FK_5D9F75A1783E3463');
        $this->addSql('DROP INDEX UNIQ_5D9F75A1A76ED395');
        $this->addSql('DROP INDEX IDX_5D9F75A1783E3463');
        $this->addSql('ALTER TABLE employee ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE employee ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE employee DROP user_id');
        $this->addSql('ALTER TABLE employee DROP manager_id');
        $this->addSql('ALTER TABLE employee ALTER last_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE employee ALTER first_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE employee ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT fk_5d9f75a1727aca70 FOREIGN KEY (parent_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_5d9f75a1727aca70 ON employee (parent_id)');
    }
}
