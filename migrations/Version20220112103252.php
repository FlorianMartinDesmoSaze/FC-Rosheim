<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220112103252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `user` 
        (
            id INT AUTO_INCREMENT NOT NULL, 
            mail VARCHAR(255) NOT NULL, 
            password VARCHAR(255) NOT NULL, role JSON DEFAULT NULL, 
            nickname VARCHAR(255) DEFAULT NULL, 
            phone VARCHAR(12) DEFAULT NULL, 
            last_name VARCHAR(255) DEFAULT NULL, 
            first_name VARCHAR(255) DEFAULT NULL, 
            birthdate DATETIME DEFAULT NULL, 
            license TINYINT(1) NOT NULL, 
            PRIMARY KEY(id),
            
        ),
        -- CREATE TABLE staff (
        --         id INT AUTO_INCREMENT NOT NULL, 
        --         last_name VARCHAR(255) NOT NULL, 
        --         first_name VARCHAR(255) NOT NULL, 
        --         position VARCHAR(255) NOT NULL, 
        --         phone VARCHAR(12) DEFAULT NULL, 
        --         email VARCHAR(255) DEFAULT NULL, 
        --         PRIMARY KEY(id)
        --     )
                DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
            );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE `user`');
    }
}
