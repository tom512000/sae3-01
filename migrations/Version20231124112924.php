<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231124112924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inscrire (status INT NOT NULL, date_demande DATETIME NOT NULL, idOffre INT NOT NULL, idUser INT NOT NULL, INDEX IDX_84CA37A8B842C572 (idOffre), INDEX IDX_84CA37A8FE6E88D7 (idUser), PRIMARY KEY(idOffre, idUser)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscrire ADD CONSTRAINT FK_84CA37A8B842C572 FOREIGN KEY (idOffre) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE inscrire ADD CONSTRAINT FK_84CA37A8FE6E88D7 FOREIGN KEY (idUser) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscrire DROP FOREIGN KEY FK_84CA37A8B842C572');
        $this->addSql('ALTER TABLE inscrire DROP FOREIGN KEY FK_84CA37A8FE6E88D7');
        $this->addSql('DROP TABLE inscrire');
    }
}
