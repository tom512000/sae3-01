<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231124100826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inscrire (id INT AUTO_INCREMENT NOT NULL, offre_id INT NOT NULL, user_id INT NOT NULL, status INT NOT NULL, date_demande DATETIME NOT NULL, INDEX IDX_84CA37A84CC8505A (offre_id), INDEX IDX_84CA37A8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscrire ADD CONSTRAINT FK_84CA37A84CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE inscrire ADD CONSTRAINT FK_84CA37A8A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscrire DROP FOREIGN KEY FK_84CA37A84CC8505A');
        $this->addSql('ALTER TABLE inscrire DROP FOREIGN KEY FK_84CA37A8A76ED395');
        $this->addSql('DROP TABLE inscrire');
    }
}
