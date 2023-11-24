<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231124154851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscrire DROP FOREIGN KEY FK_84CA37A84CC8505A');
        $this->addSql('ALTER TABLE inscrire DROP FOREIGN KEY FK_84CA37A8A76ED395');
        $this->addSql('DROP INDEX IDX_84CA37A84CC8505A ON inscrire');
        $this->addSql('DROP INDEX IDX_84CA37A8A76ED395 ON inscrire');
        $this->addSql('DROP INDEX `primary` ON inscrire');
        $this->addSql('ALTER TABLE inscrire ADD idOffre INT NOT NULL, ADD idUser INT NOT NULL, DROP offre_id, DROP user_id');
        $this->addSql('ALTER TABLE inscrire ADD CONSTRAINT FK_84CA37A8B842C572 FOREIGN KEY (idOffre) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE inscrire ADD CONSTRAINT FK_84CA37A8FE6E88D7 FOREIGN KEY (idUser) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_84CA37A8B842C572 ON inscrire (idOffre)');
        $this->addSql('CREATE INDEX IDX_84CA37A8FE6E88D7 ON inscrire (idUser)');
        $this->addSql('ALTER TABLE inscrire ADD PRIMARY KEY (idOffre, idUser)');
        $this->addSql('ALTER TABLE user ADD cv VARCHAR(255), ADD lettre_motiv VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP cv, DROP lettre_motiv');
        $this->addSql('ALTER TABLE inscrire DROP FOREIGN KEY FK_84CA37A8B842C572');
        $this->addSql('ALTER TABLE inscrire DROP FOREIGN KEY FK_84CA37A8FE6E88D7');
        $this->addSql('DROP INDEX IDX_84CA37A8B842C572 ON inscrire');
        $this->addSql('DROP INDEX IDX_84CA37A8FE6E88D7 ON inscrire');
        $this->addSql('DROP INDEX `PRIMARY` ON inscrire');
        $this->addSql('ALTER TABLE inscrire ADD offre_id INT NOT NULL, ADD user_id INT NOT NULL, DROP idOffre, DROP idUser');
        $this->addSql('ALTER TABLE inscrire ADD CONSTRAINT FK_84CA37A84CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE inscrire ADD CONSTRAINT FK_84CA37A8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_84CA37A84CC8505A ON inscrire (offre_id)');
        $this->addSql('CREATE INDEX IDX_84CA37A8A76ED395 ON inscrire (user_id)');
        $this->addSql('ALTER TABLE inscrire ADD PRIMARY KEY (offre_id, user_id)');
    }
}
