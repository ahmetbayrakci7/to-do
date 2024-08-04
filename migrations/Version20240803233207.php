<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240803233207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE to_do_list DROP FOREIGN KEY FK_4A6048ECEF27A0A5');
        $this->addSql('CREATE TABLE developer_jobs (id INT AUTO_INCREMENT NOT NULL, developer_id INT DEFAULT NULL, to_do_list_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_F543108664DD9267 (developer_id), INDEX IDX_F5431086B3AB48EB (to_do_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE developer_jobs ADD CONSTRAINT FK_F543108664DD9267 FOREIGN KEY (developer_id) REFERENCES developer (id)');
        $this->addSql('ALTER TABLE developer_jobs ADD CONSTRAINT FK_F5431086B3AB48EB FOREIGN KEY (to_do_list_id) REFERENCES to_do_list (id)');
        $this->addSql('DROP TABLE to_do_api');
        $this->addSql('DROP INDEX IDX_4A6048ECEF27A0A5 ON to_do_list');
        $this->addSql('ALTER TABLE to_do_list DROP to_do_api_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE to_do_api (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, api_url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, service VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE developer_jobs DROP FOREIGN KEY FK_F543108664DD9267');
        $this->addSql('ALTER TABLE developer_jobs DROP FOREIGN KEY FK_F5431086B3AB48EB');
        $this->addSql('DROP TABLE developer_jobs');
        $this->addSql('ALTER TABLE to_do_list ADD to_do_api_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE to_do_list ADD CONSTRAINT FK_4A6048ECEF27A0A5 FOREIGN KEY (to_do_api_id) REFERENCES to_do_api (id)');
        $this->addSql('CREATE INDEX IDX_4A6048ECEF27A0A5 ON to_do_list (to_do_api_id)');
    }
}
