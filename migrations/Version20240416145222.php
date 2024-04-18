<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416145222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultaion ADD specialite_id INT DEFAULT NULL, DROP specialite');
        $this->addSql('ALTER TABLE consultaion ADD CONSTRAINT FK_75E4FF312195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id)');
        $this->addSql('CREATE INDEX IDX_75E4FF312195E0F0 ON consultaion (specialite_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultaion DROP FOREIGN KEY FK_75E4FF312195E0F0');
        $this->addSql('DROP INDEX IDX_75E4FF312195E0F0 ON consultaion');
        $this->addSql('ALTER TABLE consultaion ADD specialite INT NOT NULL, DROP specialite_id');
    }
}
