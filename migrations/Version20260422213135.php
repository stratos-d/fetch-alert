<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260422213135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE devices (id INT AUTO_INCREMENT NOT NULL, platform VARCHAR(50) NOT NULL, label VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, user_id INT NOT NULL, INDEX IDX_11074E9AA76ED395 (user_id), INDEX idx_devices_user_type (user_id, platform), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, status VARCHAR(50) NOT NULL, is_premium TINYINT NOT NULL, country_code VARCHAR(2) NOT NULL, last_active_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE devices ADD CONSTRAINT FK_11074E9AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE devices DROP FOREIGN KEY FK_11074E9AA76ED395');
        $this->addSql('DROP TABLE devices');
        $this->addSql('DROP TABLE users');
    }
}
