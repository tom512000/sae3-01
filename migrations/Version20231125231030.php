<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231125231030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_demander (skill_id INT NOT NULL, offre_id INT NOT NULL, INDEX IDX_883B51DF5585C142 (skill_id), INDEX IDX_883B51DF4CC8505A (offre_id), PRIMARY KEY(skill_id, offre_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE skill_demander ADD CONSTRAINT FK_883B51DF5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE skill_demander ADD CONSTRAINT FK_883B51DF4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE offre ADD level VARCHAR(64) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill_demander DROP FOREIGN KEY FK_883B51DF5585C142');
        $this->addSql('ALTER TABLE skill_demander DROP FOREIGN KEY FK_883B51DF4CC8505A');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE skill_demander');
        $this->addSql('ALTER TABLE `user` CHANGE cv cv VARCHAR(255) DEFAULT NULL, CHANGE lettre_motiv lettre_motiv VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE offre DROP level');
    }
}
