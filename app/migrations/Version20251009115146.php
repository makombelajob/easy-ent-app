<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251009115146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD students_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E91AD8D010 FOREIGN KEY (students_id) REFERENCES students (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E91AD8D010 ON users (students_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E91AD8D010');
        $this->addSql('DROP INDEX UNIQ_1483A5E91AD8D010 ON users');
        $this->addSql('ALTER TABLE users DROP students_id');
    }
}
