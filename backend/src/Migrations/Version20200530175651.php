<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200530175651 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1F3B4DBDF FOREIGN KEY (employee_sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D14C752CCB FOREIGN KEY (employee_receiver_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_723705D1F3B4DBDF ON transaction (employee_sender_id)');
        $this->addSql('CREATE INDEX IDX_723705D14C752CCB ON transaction (employee_receiver_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1F3B4DBDF');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D14C752CCB');
        $this->addSql('DROP INDEX IDX_723705D1F3B4DBDF ON transaction');
        $this->addSql('DROP INDEX IDX_723705D14C752CCB ON transaction');
    }
}
