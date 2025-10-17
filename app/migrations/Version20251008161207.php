<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251008161207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admins (id INT AUTO_INCREMENT NOT NULL, department VARCHAR(100) DEFAULT NULL, hire_date DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', is_super_admin TINYINT(1) NOT NULL, position VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE courses (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, code VARCHAR(20) NOT NULL, hours INT NOT NULL, level VARCHAR(50) DEFAULT NULL, class VARCHAR(50) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE courses_students (courses_id INT NOT NULL, students_id INT NOT NULL, INDEX IDX_5D696B20F9295384 (courses_id), INDEX IDX_5D696B201AD8D010 (students_id), PRIMARY KEY(courses_id, students_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grades (id INT AUTO_INCREMENT NOT NULL, teachers_id INT DEFAULT NULL, students_id INT DEFAULT NULL, value NUMERIC(10, 2) NOT NULL, comment LONGTEXT DEFAULT NULL, type VARCHAR(50) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_3AE3611084365182 (teachers_id), INDEX IDX_3AE361101AD8D010 (students_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parent_users (id INT AUTO_INCREMENT NOT NULL, profession VARCHAR(100) DEFAULT NULL, workspace VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parent_users_students (parent_users_id INT NOT NULL, students_id INT NOT NULL, INDEX IDX_C1F5D263F87E18EC (parent_users_id), INDEX IDX_C1F5D2631AD8D010 (students_id), PRIMARY KEY(parent_users_id, students_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payments (id INT AUTO_INCREMENT NOT NULL, students_id INT DEFAULT NULL, parent_users_id INT DEFAULT NULL, amount NUMERIC(10, 2) NOT NULL, type VARCHAR(50) NOT NULL, status VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, due_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', paid_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', stripe_payment_intend_id VARCHAR(50) DEFAULT NULL, stripe_session_id VARCHAR(50) DEFAULT NULL, INDEX IDX_65D29B321AD8D010 (students_id), INDEX IDX_65D29B32F87E18EC (parent_users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE students (id INT AUTO_INCREMENT NOT NULL, date_of_birth DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', address VARCHAR(100) DEFAULT NULL, class VARCHAR(50) DEFAULT NULL, level VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teachers (id INT AUTO_INCREMENT NOT NULL, teacher_number VARCHAR(50) NOT NULL, speciality VARCHAR(100) DEFAULT NULL, department VARCHAR(100) DEFAULT NULL, hire_date DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teachers_courses (teachers_id INT NOT NULL, courses_id INT NOT NULL, INDEX IDX_B83E790D84365182 (teachers_id), INDEX IDX_B83E790DF9295384 (courses_id), PRIMARY KEY(teachers_id, courses_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, last_name VARCHAR(50) NOT NULL, first_name VARCHAR(50) NOT NULL, phone VARCHAR(50) NOT NULL, create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE courses_students ADD CONSTRAINT FK_5D696B20F9295384 FOREIGN KEY (courses_id) REFERENCES courses (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE courses_students ADD CONSTRAINT FK_5D696B201AD8D010 FOREIGN KEY (students_id) REFERENCES students (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE grades ADD CONSTRAINT FK_3AE3611084365182 FOREIGN KEY (teachers_id) REFERENCES teachers (id)');
        $this->addSql('ALTER TABLE grades ADD CONSTRAINT FK_3AE361101AD8D010 FOREIGN KEY (students_id) REFERENCES students (id)');
        $this->addSql('ALTER TABLE parent_users_students ADD CONSTRAINT FK_C1F5D263F87E18EC FOREIGN KEY (parent_users_id) REFERENCES parent_users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parent_users_students ADD CONSTRAINT FK_C1F5D2631AD8D010 FOREIGN KEY (students_id) REFERENCES students (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE payments ADD CONSTRAINT FK_65D29B321AD8D010 FOREIGN KEY (students_id) REFERENCES students (id)');
        $this->addSql('ALTER TABLE payments ADD CONSTRAINT FK_65D29B32F87E18EC FOREIGN KEY (parent_users_id) REFERENCES parent_users (id)');
        $this->addSql('ALTER TABLE teachers_courses ADD CONSTRAINT FK_B83E790D84365182 FOREIGN KEY (teachers_id) REFERENCES teachers (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE teachers_courses ADD CONSTRAINT FK_B83E790DF9295384 FOREIGN KEY (courses_id) REFERENCES courses (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE courses_students DROP FOREIGN KEY FK_5D696B20F9295384');
        $this->addSql('ALTER TABLE courses_students DROP FOREIGN KEY FK_5D696B201AD8D010');
        $this->addSql('ALTER TABLE grades DROP FOREIGN KEY FK_3AE3611084365182');
        $this->addSql('ALTER TABLE grades DROP FOREIGN KEY FK_3AE361101AD8D010');
        $this->addSql('ALTER TABLE parent_users_students DROP FOREIGN KEY FK_C1F5D263F87E18EC');
        $this->addSql('ALTER TABLE parent_users_students DROP FOREIGN KEY FK_C1F5D2631AD8D010');
        $this->addSql('ALTER TABLE payments DROP FOREIGN KEY FK_65D29B321AD8D010');
        $this->addSql('ALTER TABLE payments DROP FOREIGN KEY FK_65D29B32F87E18EC');
        $this->addSql('ALTER TABLE teachers_courses DROP FOREIGN KEY FK_B83E790D84365182');
        $this->addSql('ALTER TABLE teachers_courses DROP FOREIGN KEY FK_B83E790DF9295384');
        $this->addSql('DROP TABLE admins');
        $this->addSql('DROP TABLE courses');
        $this->addSql('DROP TABLE courses_students');
        $this->addSql('DROP TABLE grades');
        $this->addSql('DROP TABLE parent_users');
        $this->addSql('DROP TABLE parent_users_students');
        $this->addSql('DROP TABLE payments');
        $this->addSql('DROP TABLE students');
        $this->addSql('DROP TABLE teachers');
        $this->addSql('DROP TABLE teachers_courses');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
