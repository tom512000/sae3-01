<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231120123253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, nom_ent VARCHAR(128) NOT NULL, adresse VARCHAR(128) NOT NULL, mail VARCHAR(128) NOT NULL, site_web VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offre DROP id_offre, CHANGE id_entreprise idEntreprise INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F8FEDE48A FOREIGN KEY (idEntreprise) REFERENCES entreprise (id)');
        $this->addSql('CREATE INDEX IDX_AF86866F8FEDE48A ON offre (idEntreprise)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F8FEDE48A');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP INDEX IDX_AF86866F8FEDE48A ON offre');
        $this->addSql('ALTER TABLE offre ADD id_offre INT NOT NULL, CHANGE idEntreprise id_entreprise INT DEFAULT NULL');
    }
}
