<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240304185034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assurance ADD favoris TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE assurance ADD CONSTRAINT FK_386829AE1823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id)');
        $this->addSql('CREATE INDEX IDX_386829AE1823061F ON assurance (contrat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assurance DROP FOREIGN KEY FK_386829AE1823061F');
        $this->addSql('DROP INDEX IDX_386829AE1823061F ON assurance');
        $this->addSql('ALTER TABLE assurance DROP favoris');
    }
}
