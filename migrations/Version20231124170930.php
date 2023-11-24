<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231124170930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(128) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offre CHANGE id_type type_id INT NOT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_AF86866FC54C8C93 ON offre (type_id)');
        $this->addSql('ALTER TABLE user CHANGE cv cv VARCHAR(255), CHANGE lettre_motiv lettre_motiv VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FC54C8C93');
        $this->addSql('DROP TABLE type');
        $this->addSql('ALTER TABLE `user` CHANGE cv cv VARCHAR(255) DEFAULT NULL, CHANGE lettre_motiv lettre_motiv VARCHAR(255) DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_AF86866FC54C8C93 ON offre');
        $this->addSql('ALTER TABLE offre CHANGE type_id id_type INT NOT NULL');
    }
}
