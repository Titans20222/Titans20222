<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220216150534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, produit_id INT NOT NULL, text VARCHAR(255) NOT NULL, INDEX IDX_67F068BCF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, createur_id INT NOT NULL, nom_evenement VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, INDEX IDX_B26681E73A201E5 (createur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, createur_id INT DEFAULT NULL, nom_formation VARCHAR(50) NOT NULL, objectif_global VARCHAR(255) DEFAULT NULL, INDEX IDX_404021BF73A201E5 (createur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_client (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, formation_id INT NOT NULL, INDEX IDX_E75D0A7819EB6921 (client_id), INDEX IDX_E75D0A785200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE linecommande (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_AF06C66782EA2E54 (commande_id), INDEX IDX_AF06C667F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paiement (id INT AUTO_INCREMENT NOT NULL, formation_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B1DC7A1E5200282E (formation_id), INDEX IDX_B1DC7A1EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, createur_id INT DEFAULT NULL, categorie_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_29A5EC2773A201E5 (createur_id), INDEX IDX_29A5EC27BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, evennement_id INT NOT NULL, user_id INT NOT NULL, prixtotale DOUBLE PRECISION NOT NULL, INDEX IDX_97A0ADA3DCDFA082 (evennement_id), INDEX IDX_97A0ADA3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E73A201E5 FOREIGN KEY (createur_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF73A201E5 FOREIGN KEY (createur_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE formation_client ADD CONSTRAINT FK_E75D0A7819EB6921 FOREIGN KEY (client_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE formation_client ADD CONSTRAINT FK_E75D0A785200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE linecommande ADD CONSTRAINT FK_AF06C66782EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE linecommande ADD CONSTRAINT FK_AF06C667F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E5200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC2773A201E5 FOREIGN KEY (createur_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3DCDFA082 FOREIGN KEY (evennement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27BCF5E72D');
        $this->addSql('ALTER TABLE linecommande DROP FOREIGN KEY FK_AF06C66782EA2E54');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3DCDFA082');
        $this->addSql('ALTER TABLE formation_client DROP FOREIGN KEY FK_E75D0A785200282E');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E5200282E');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCF347EFB');
        $this->addSql('ALTER TABLE linecommande DROP FOREIGN KEY FK_AF06C667F347EFB');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E73A201E5');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF73A201E5');
        $this->addSql('ALTER TABLE formation_client DROP FOREIGN KEY FK_E75D0A7819EB6921');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1EA76ED395');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC2773A201E5');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3A76ED395');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE formation_client');
        $this->addSql('DROP TABLE linecommande');
        $this->addSql('DROP TABLE paiement');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE users');
    }
}
