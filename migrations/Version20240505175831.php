<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240505175831 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence ADD id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('DROP INDEX idx_5a3811fb96ef99bf ON schedule');
        $this->addSql('CREATE INDEX IDX_5A3811FB591CC992 ON schedule (course_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absence MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON absence');
        $this->addSql('ALTER TABLE absence DROP id');
        $this->addSql('ALTER TABLE absence ADD PRIMARY KEY (student_id, course_id, absencedate)');
        $this->addSql('DROP INDEX IDX_5A3811FB591CC992 ON schedule');
        $this->addSql('CREATE INDEX IDX_5A3811FB96EF99BF ON schedule (course_id)');
    }
}
