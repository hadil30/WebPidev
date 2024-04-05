<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240324225313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse CHANGE is_correct is_correct TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE test CHANGE temp_pris temp_pris DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse CHANGE is_correct is_correct TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE test CHANGE temp_pris temp_pris DATETIME DEFAULT NULL');
    }
}
