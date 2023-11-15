<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231115160818 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(180) NOT NULL, last_name VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Inscrire DROP FOREIGN KEY FK_INSCRIRE_INSCRIRE__ADMINIST');
        $this->addSql('ALTER TABLE Inscrire DROP FOREIGN KEY FK_INSCRIRE_INSCRIRE__ETUDIANT');
        $this->addSql('ALTER TABLE Inscrire DROP FOREIGN KEY FK_INSCRIRE_INSCRIRE__OFFRE');
        $this->addSql('ALTER TABLE Technologie_offre DROP FOREIGN KEY FK_TECHNOLO_TECHNOLOG_OFFRE');
        $this->addSql('ALTER TABLE Technologie_offre DROP FOREIGN KEY FK_TECHNOLO_TECHNOLOG_TECHNOLO');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_OFFRE_GERER_ADMINIST');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_OFFRE_TYPE_OFFR_TYPE');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_OFFRE_ENTREPRIS_ENTREPRI');
        $this->addSql('DROP TABLE Administrateur');
        $this->addSql('DROP TABLE Entreprise');
        $this->addSql('DROP TABLE Etudiant');
        $this->addSql('DROP TABLE Technologie');
        $this->addSql('DROP TABLE Type');
        $this->addSql('DROP TABLE Inscrire');
        $this->addSql('DROP TABLE Technologie_offre');
        $this->addSql('DROP TABLE offre');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Administrateur (ID_admin INT NOT NULL, lastName VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, firstName VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, loginUser VARCHAR(40) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, sha512pass VARCHAR(512) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, phone VARCHAR(10) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, mail VARCHAR(100) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, dateNais DATE DEFAULT NULL, PRIMARY KEY(ID_admin)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE Entreprise (ID_entreprise INT NOT NULL, nameEnt VARCHAR(128) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, adresse VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, siteWeb VARCHAR(128) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, PRIMARY KEY(ID_entreprise)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE Etudiant (ID_etud INT NOT NULL, lastName VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, firstName VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, loginUser VARCHAR(40) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, sha512pass VARCHAR(512) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, phone VARCHAR(10) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, mail VARCHAR(100) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, dateNais DATE DEFAULT NULL, PRIMARY KEY(ID_etud)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE Technologie (ID_technologie INT NOT NULL, nameTech VARCHAR(128) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, PRIMARY KEY(ID_technologie)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE Type (ID_type INT NOT NULL, libelle VARCHAR(128) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, PRIMARY KEY(ID_type)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE Inscrire (id_inscrire INT NOT NULL, ID_offre INT NOT NULL, ID_admin INT DEFAULT NULL, ID_etud INT DEFAULT NULL, Statut INT DEFAULT 1 NOT NULL, dateDemande DATE NOT NULL, INDEX INSCRIRE_OFFRE_FK (ID_offre), INDEX FK_INSCRIRE_INSCRIRE__ADMINIST (ID_admin), INDEX INSCRIRE_UTILISATEUR_FK (ID_etud), PRIMARY KEY(id_inscrire)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE Technologie_offre (ID_technologie INT NOT NULL, ID_offre INT NOT NULL, INDEX TECHNOLOGIE_OFFRE2_FK (ID_offre), INDEX TECHNOLOGIE_OFFRE_FK (ID_technologie), PRIMARY KEY(ID_technologie, ID_offre)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE offre (ID_offre INT NOT NULL, ID_type INT NOT NULL, ID_entreprise INT DEFAULT NULL, ID_admin INT DEFAULT NULL, name VARCHAR(128) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, duree INT NOT NULL, lieux VARCHAR(128) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, jourDeb DATE NOT NULL, nbPlace INT NOT NULL, description VARCHAR(256) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, INDEX FK_OFFRE_ENTREPRIS_ENTREPRI (ID_entreprise), INDEX FK_OFFRE_TYPE_OFFR_TYPE (ID_type), INDEX FK_OFFRE_GERER_ADMINIST (ID_admin), PRIMARY KEY(ID_offre)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE Inscrire ADD CONSTRAINT FK_INSCRIRE_INSCRIRE__ADMINIST FOREIGN KEY (ID_admin) REFERENCES Administrateur (ID_admin)');
        $this->addSql('ALTER TABLE Inscrire ADD CONSTRAINT FK_INSCRIRE_INSCRIRE__ETUDIANT FOREIGN KEY (ID_etud) REFERENCES Etudiant (ID_etud)');
        $this->addSql('ALTER TABLE Inscrire ADD CONSTRAINT FK_INSCRIRE_INSCRIRE__OFFRE FOREIGN KEY (ID_offre) REFERENCES offre (ID_offre)');
        $this->addSql('ALTER TABLE Technologie_offre ADD CONSTRAINT FK_TECHNOLO_TECHNOLOG_OFFRE FOREIGN KEY (ID_offre) REFERENCES offre (ID_offre)');
        $this->addSql('ALTER TABLE Technologie_offre ADD CONSTRAINT FK_TECHNOLO_TECHNOLOG_TECHNOLO FOREIGN KEY (ID_technologie) REFERENCES Technologie (ID_technologie)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_OFFRE_GERER_ADMINIST FOREIGN KEY (ID_admin) REFERENCES Administrateur (ID_admin)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_OFFRE_TYPE_OFFR_TYPE FOREIGN KEY (ID_type) REFERENCES Type (ID_type)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_OFFRE_ENTREPRIS_ENTREPRI FOREIGN KEY (ID_entreprise) REFERENCES Entreprise (ID_entreprise)');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
