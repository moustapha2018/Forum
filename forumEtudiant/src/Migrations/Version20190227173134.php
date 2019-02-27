<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190227173134 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C39978F7A');
        $this->addSql('DROP INDEX IDX_9474526C39978F7A ON comment');
        $this->addSql('ALTER TABLE comment ADD sujet_id INT DEFAULT NULL, DROP sujetscomment_id');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C7C4D497E FOREIGN KEY (sujet_id) REFERENCES sujet (id)');
        $this->addSql('CREATE INDEX IDX_9474526C7C4D497E ON comment (sujet_id)');
        $this->addSql('ALTER TABLE sujet CHANGE image image VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C7C4D497E');
        $this->addSql('DROP INDEX IDX_9474526C7C4D497E ON comment');
        $this->addSql('ALTER TABLE comment ADD sujetscomment_id INT DEFAULT NULL, DROP sujet_id');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C39978F7A FOREIGN KEY (sujetscomment_id) REFERENCES sujet (id)');
        $this->addSql('CREATE INDEX IDX_9474526C39978F7A ON comment (sujetscomment_id)');
        $this->addSql('ALTER TABLE sujet CHANGE image image VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
