<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190227170707 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_sujet (user_id INT NOT NULL, sujet_id INT NOT NULL, INDEX IDX_CCD1A2C5A76ED395 (user_id), INDEX IDX_CCD1A2C57C4D497E (sujet_id), PRIMARY KEY(user_id, sujet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_sujet ADD CONSTRAINT FK_CCD1A2C5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_sujet ADD CONSTRAINT FK_CCD1A2C57C4D497E FOREIGN KEY (sujet_id) REFERENCES sujet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sujet CHANGE image image VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_sujet');
        $this->addSql('ALTER TABLE sujet CHANGE image image VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
