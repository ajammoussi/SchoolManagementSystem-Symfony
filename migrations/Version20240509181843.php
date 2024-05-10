<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509181843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE or replace TABLE pdf_file (filename VARCHAR(255) NOT NULL, content LONGBLOB NOT NULL, PRIMARY KEY(filename)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE or replace TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql("
-- Create trigger to update user table when admin table is updated
CREATE TRIGGER trg_admin_after_insert
AFTER INSERT ON admin
FOR EACH ROW
BEGIN
    INSERT INTO user (email, roles, password) VALUES (NEW.email, 'ROLE_ADMIN', NEW.password);
END;");

$this->addSql("
-- Create trigger to update user table when student table is updated
CREATE TRIGGER trg_student_after_insert
AFTER INSERT ON student
FOR EACH ROW
BEGIN
    INSERT INTO user (email, roles, password) VALUES (NEW.email, 'ROLE_STUDENT', NEW.password);
END;");

$this->addSql("
-- Create trigger to update user table when teacher table is updated
CREATE TRIGGER trg_teacher_after_insert
AFTER INSERT ON teacher
FOR EACH ROW
BEGIN
    INSERT INTO user (email, roles, password) VALUES (NEW.email, 'ROLE_TEACHER', NEW.password);
END;");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE pdf_file');
        $this->addSql('DROP TABLE user');

    }
}
