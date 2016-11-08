<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1490852282.
 * Generated on 2017-03-30 05:38:02 by vagrant
 */
class PropelMigration_1490852282
{
    public $comment = '';

    public function preUp(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postUp(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    public function preDown(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postDown(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
      $sql =<<<eos
SET FOREIGN_KEY_CHECKS = 0;
CREATE TABLE `users`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(255) NOT NULL,
    `password` CHAR(255) NOT NULL,
    `first_name` VARCHAR(255),
    `last_name` VARCHAR(255),
    `telephone` VARCHAR(20),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `groups`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `is_staff` TINYINT(1) DEFAULT 0,
    `managed_group_id` INTEGER,
    PRIMARY KEY (`id`),
    INDEX `groups_fi_462c82` (`managed_group_id`),
    CONSTRAINT `groups_fk_462c82`
        FOREIGN KEY (`managed_group_id`)
        REFERENCES `groups` (`id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE `auth_scopes`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(45) NOT NULL,
    `is_default` TINYINT(1) DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `groups_auth_scopes`
(
    `group_id` INTEGER NOT NULL,
    `auth_scope_id` INTEGER NOT NULL,
    PRIMARY KEY (`group_id`,`auth_scope_id`),
    INDEX `groups_auth_scopes_fi_de1df4` (`auth_scope_id`),
    CONSTRAINT `groups_auth_scopes_fk_59fbd5`
        FOREIGN KEY (`group_id`)
        REFERENCES `groups` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `groups_auth_scopes_fk_de1df4`
        FOREIGN KEY (`auth_scope_id`)
        REFERENCES `auth_scopes` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `auth_clients`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `client_id` VARCHAR(255) NOT NULL,
    `client_secret` VARCHAR(255) NOT NULL,
    `redirect_url` VARCHAR(255),
    `grant_types` TEXT,
    `scope` TEXT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `auth_tokens`
(
    `token` VARCHAR(255) NOT NULL,
    `type` VARCHAR(255) NOT NULL,
    `redirect_url` VARCHAR(255),
    `expires` DATETIME NOT NULL,
    `scope` TEXT,
    `user_id` INTEGER,
    `client_id` INTEGER,
    PRIMARY KEY (`token`),
    INDEX `auth_tokens_fi_69bd79` (`user_id`),
    INDEX `auth_tokens_fi_859764` (`client_id`),
    CONSTRAINT `auth_tokens_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `auth_tokens_fk_859764`
        FOREIGN KEY (`client_id`)
        REFERENCES `auth_clients` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `auth_codes`
(
    `auth_code` VARCHAR(255) NOT NULL,
    `redirect_url` VARCHAR(255),
    `expires` DATETIME NOT NULL,
    `scope` TEXT,
    `user_id` INTEGER,
    `client_id` INTEGER NOT NULL,
    PRIMARY KEY (`auth_code`),
    INDEX `auth_codes_fi_69bd79` (`user_id`),
    INDEX `auth_codes_fi_859764` (`client_id`),
    CONSTRAINT `auth_codes_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `auth_codes_fk_859764`
        FOREIGN KEY (`client_id`)
        REFERENCES `auth_clients` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE `users_groups`
(
    `user_id` INTEGER NOT NULL,
    `group_id` INTEGER NOT NULL,
    INDEX `users_groups_fi_69bd79` (`user_id`),
    INDEX `users_groups_fi_59fbd5` (`group_id`),
    CONSTRAINT `users_groups_fk_69bd79`
        FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `users_groups_fk_59fbd5`
        FOREIGN KEY (`group_id`)
        REFERENCES `groups` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

SET FOREIGN_KEY_CHECKS = 1;
eos;
        return array (
  'default' => $sql,
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
      $sql =<<<eos
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `groups`;
DROP TABLE IF EXISTS `auth_scopes`;
DROP TABLE IF EXISTS `groups_auth_scopes`;
DROP TABLE IF EXISTS `auth_clients`;
DROP TABLE IF EXISTS `auth_tokens`;
DROP TABLE IF EXISTS `auth_codes`;
DROP TABLE IF EXISTS `users_groups`;
SET FOREIGN_KEY_CHECKS = 1;
eos;
        return array (
  'default' => $sql,
);
    }

}