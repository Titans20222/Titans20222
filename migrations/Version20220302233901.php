<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220302233901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_de_commande ADD commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne_de_commande ADD CONSTRAINT FK_7982ACE682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_7982ACE682EA2E54 ON ligne_de_commande (commande_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie CHANGE nom_categorie nom_categorie VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE commande CHANGE numc numc VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE Ville Ville VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE adresselivraison adresselivraison VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prix_total prix_total VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE evenement CHANGE nom_evenement nom_evenement VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE formation CHANGE nom_formation nom_formation VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE objectif_global objectif_global VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ligne_de_commande DROP FOREIGN KEY FK_7982ACE682EA2E54');
        $this->addSql('DROP INDEX IDX_7982ACE682EA2E54 ON ligne_de_commande');
        $this->addSql('ALTER TABLE ligne_de_commande DROP commande_id, CHANGE numcommande numcommande VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prix prix VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE qte qte VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ligne ligne VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE produit CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE users CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
