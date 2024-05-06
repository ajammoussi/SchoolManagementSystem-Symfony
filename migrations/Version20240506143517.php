<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240506143517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absence (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, course_id INT NOT NULL, absencedate DATE NOT NULL, INDEX IDX_765AE0C9CB944F1A (student_id), INDEX IDX_765AE0C9591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, coursename VARCHAR(255) NOT NULL, field VARCHAR(255) NOT NULL, studylevel VARCHAR(255) NOT NULL, INDEX IDX_169E6FB941807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_video (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, field VARCHAR(255) NOT NULL, studylevel INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE request (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone INT NOT NULL, address VARCHAR(255) NOT NULL, birthdate DATE NOT NULL, gender VARCHAR(255) NOT NULL, nationality VARCHAR(255) NOT NULL, field VARCHAR(255) NOT NULL, education VARCHAR(255) NOT NULL, program VARCHAR(255) NOT NULL, achievements LONGTEXT NOT NULL, essay LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedule (schedule_id INT NOT NULL, course_id INT NOT NULL, instructor_id INT NOT NULL, start_date DATE NOT NULL, start_time TIME NOT NULL, end_time TIME NOT NULL, room VARCHAR(255) DEFAULT NULL, description VARCHAR(255) NOT NULL, expiry_date DATETIME NOT NULL, field VARCHAR(255) NOT NULL, studylevel INT NOT NULL, INDEX IDX_5A3811FB591CC992 (course_id), INDEX IDX_5A3811FB8C4FC193 (instructor_id), PRIMARY KEY(schedule_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, phone INT DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, birthdate DATE DEFAULT NULL, gender VARCHAR(255) DEFAULT NULL, nationality VARCHAR(255) DEFAULT NULL, field VARCHAR(255) NOT NULL, studylevel INT NOT NULL, class INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, phone INT DEFAULT NULL, gender VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB941807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB8C4FC193 FOREIGN KEY (instructor_id) REFERENCES teacher (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9CB944F1A');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9591CC992');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB941807E1D');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB591CC992');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB8C4FC193');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE course_video');
        $this->addSql('DROP TABLE request');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE teacher');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
