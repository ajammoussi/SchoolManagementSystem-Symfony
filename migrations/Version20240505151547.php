<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240505151547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9CB944F1A');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9591CC992');
        $this->addSql('DROP INDEX IDX_765AE0C9CB944F1A ON absence');
        $this->addSql('DROP INDEX `primary` ON absence');
        $this->addSql('DROP INDEX IDX_765AE0C9591CC992 ON absence');
        $this->addSql('ALTER TABLE absence ADD student_id INT NOT NULL, ADD course_id INT NOT NULL, DROP student, DROP course');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('CREATE INDEX IDX_765AE0C9CB944F1A ON absence (student_id)');
        $this->addSql('ALTER TABLE absence ADD PRIMARY KEY (student_id, course_id, absencedate)');
        $this->addSql('CREATE INDEX IDX_765AE0C9591CC992 ON absence (course_id)');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB941807E1D');
        $this->addSql('DROP INDEX IDX_169E6FB941807E1D ON course');
        $this->addSql('ALTER TABLE course CHANGE teacher teacher_id INT NOT NULL');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB941807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
        $this->addSql('CREATE INDEX IDX_169E6FB941807E1D ON course (teacher_id)');
        $this->addSql('ALTER TABLE schedule CHANGE course_id course_id INT NOT NULL');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB96EF99BF FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('CREATE INDEX IDX_5A3811FB96EF99BF ON schedule (course_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9CB944F1A');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9591CC992');
        $this->addSql('DROP INDEX IDX_765AE0C9CB944F1A ON absence');
        $this->addSql('DROP INDEX IDX_765AE0C9591CC992 ON absence');
        $this->addSql('DROP INDEX `PRIMARY` ON absence');
        $this->addSql('ALTER TABLE absence ADD student INT NOT NULL, ADD course INT NOT NULL, DROP student_id, DROP course_id');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9CB944F1A FOREIGN KEY (student) REFERENCES student (id)');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9591CC992 FOREIGN KEY (course) REFERENCES course (id)');
        $this->addSql('CREATE INDEX IDX_765AE0C9CB944F1A ON absence (student)');
        $this->addSql('CREATE INDEX IDX_765AE0C9591CC992 ON absence (course)');
        $this->addSql('ALTER TABLE absence ADD PRIMARY KEY (student, course, absencedate)');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB941807E1D');
        $this->addSql('DROP INDEX IDX_169E6FB941807E1D ON course');
        $this->addSql('ALTER TABLE course CHANGE teacher_id teacher INT NOT NULL');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB941807E1D FOREIGN KEY (teacher) REFERENCES teacher (id)');
        $this->addSql('CREATE INDEX IDX_169E6FB941807E1D ON course (teacher)');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB96EF99BF');
        $this->addSql('DROP INDEX IDX_5A3811FB96EF99BF ON schedule');
        $this->addSql('ALTER TABLE schedule CHANGE course_id course_id INT NOT NULL');
    }
}
