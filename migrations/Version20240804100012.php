<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240804100012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE developer_jobs DROP FOREIGN KEY FK_F5431086B3AB48EB');
        $this->addSql('DROP INDEX IDX_F5431086B3AB48EB ON developer_jobs');
        $this->addSql('ALTER TABLE developer_jobs CHANGE to_do_list_id job_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE developer_jobs ADD CONSTRAINT FK_F5431086BE04EA9 FOREIGN KEY (job_id) REFERENCES to_do_list (id)');
        $this->addSql('CREATE INDEX IDX_F5431086BE04EA9 ON developer_jobs (job_id)');
        $this->addSql('ALTER TABLE to_do_list ADD service_path VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE developer_jobs DROP FOREIGN KEY FK_F5431086BE04EA9');
        $this->addSql('DROP INDEX IDX_F5431086BE04EA9 ON developer_jobs');
        $this->addSql('ALTER TABLE developer_jobs CHANGE job_id to_do_list_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE developer_jobs ADD CONSTRAINT FK_F5431086B3AB48EB FOREIGN KEY (to_do_list_id) REFERENCES to_do_list (id)');
        $this->addSql('CREATE INDEX IDX_F5431086B3AB48EB ON developer_jobs (to_do_list_id)');
        $this->addSql('ALTER TABLE to_do_list DROP service_path');
    }
}
