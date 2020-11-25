<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20201121113100
 *
 * @package          DoctrineMigrations
 * @createDate       2020-11-25
 * @author           Robert Kubica <rkubica@edokumenty.eu>
 * @copyright (c)    eDokumenty Sp. z o.o.
 */
final class Version20201121113100 extends AbstractMigration {

    public function getDescription(): string {
        return 'Create user_auth_token table';
    }

    public function up(Schema $schema): void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "user_auth_token_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "USER_AUTH_TOKEN" (id INT NOT NULL, user_id INT NOT NULL, token VARCHAR(255) NOT NULL, is_refresh BOOLEAN NOT NULL, expire_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, resource JSON DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP INDEX uniq_8d93d6497ba2f5eb');
        $this->addSql('ALTER TABLE "USER" DROP api_token');
    }

    public function down(Schema $schema): void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE "user_auth_token_id_seq" CASCADE');
        $this->addSql('DROP TABLE "USER_AUTH_TOKEN"');
        $this->addSql('ALTER TABLE "USER" ADD api_token VARCHAR(250) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d93d6497ba2f5eb ON "USER" (api_token)');
    }

}
