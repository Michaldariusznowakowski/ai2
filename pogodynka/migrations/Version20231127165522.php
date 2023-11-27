<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
// user
use App\Entity\User;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231127165522 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // - { path: '^/admin', roles: 'ROLE_ADMIN' }
        $this->addSql('INSERT INTO user (username, password, roles) VALUES ("admin", "$2y$13$uQ5fiPBbsbhIdaKdqsZkz.E.YeFWZK8Wyx5kyjPvxjZAXbEQcLL2i", \'["ROLE_ADMIN"]\')');
        $this->addSql('INSERT INTO user (username, password, roles) VALUES ("user", "$2y$13$uQ5fiPBbsbhIdaKdqsZkz.E.YeFWZK8Wyx5kyjPvxjZAXbEQcLL2i", \'["ROLE_USER"]\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('DELETE FROM user WHERE username = "admin"');
        $this->addSql('DELETE FROM user WHERE username = "user"');
    }
}
