<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240802212726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE to_do_api (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) DEFAULT NULL, api_url VARCHAR(255) NOT NULL, service VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE to_do_list (id INT AUTO_INCREMENT NOT NULL, to_do_api_id INT DEFAULT NULL, difficulty INT NOT NULL, duration INT NOT NULL, created_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_4A6048ECEF27A0A5 (to_do_api_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE to_do_list ADD CONSTRAINT FK_4A6048ECEF27A0A5 FOREIGN KEY (to_do_api_id) REFERENCES to_do_api (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE to_do_list DROP FOREIGN KEY FK_4A6048ECEF27A0A5');
        $this->addSql('DROP TABLE to_do_api');
        $this->addSql('DROP TABLE to_do_list');
    }
}
