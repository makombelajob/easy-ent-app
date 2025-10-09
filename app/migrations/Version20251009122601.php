<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251009122601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grades ADD courses_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE grades ADD CONSTRAINT FK_3AE36110F9295384 FOREIGN KEY (courses_id) REFERENCES courses (id)');
        $this->addSql('CREATE INDEX IDX_3AE36110F9295384 ON grades (courses_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grades DROP FOREIGN KEY FK_3AE36110F9295384');
        $this->addSql('DROP INDEX IDX_3AE36110F9295384 ON grades');
        $this->addSql('ALTER TABLE grades DROP courses_id');
    }
}
