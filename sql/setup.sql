--
-- Ramverk1 SQL
-- Av: peto16, Peder Tornberg
--
SET NAMES 'utf8';
CREATE DATABASE IF NOT EXISTS peto16;
USE peto16;

DROP TABLE IF EXISTS `QandA_Tag2Question`;
DROP TABLE IF EXISTS `QandA_Tag`;
DROP TABLE IF EXISTS `QandA_Vote`;
DROP TABLE IF EXISTS `QandA_Comment`;
DROP TABLE IF EXISTS `QandA_Awnser`;
DROP TABLE IF EXISTS `QandA_Question`;
DROP TABLE IF EXISTS `ramverk1_User`;

CREATE TABLE ramverk1_User
(
    `id` INT AUTO_INCREMENT NOT NULL,
    `username` VARCHAR(30) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) DEFAULT NULL,
    `firstname` VARCHAR(40) DEFAULT NULL,
    `lastname` VARCHAR(40) DEFAULT NULL,
    `administrator` BOOLEAN DEFAULT False,
    `enabled` BOOLEAN DEFAULT True,
    `deleted` DATETIME DEFAULT NULL,

    PRIMARY KEY (`id`),
    UNIQUE KEY `username_unique` (`username`),
    UNIQUE KEY `email_unique` (`email`)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;



INSERT INTO
    ramverk1_User(username, password, email, firstname, lastname, administrator, enabled)
VALUES
    ('admin', '$2y$10$vaqfYKE2TfIzo7EQMxd8fOg3AvnPBZPTtV4l98aN4Ep6TkmjA2/Cm', 'peder.tornberg@gmail.com', 'Peder', 'Tornberg', True, True),
    ('doe', '$2y$10$dYBys9cIIKEsdtQoiIiELOVkuRbcyfMZt7L8Pinw7JHDpZEol7UN6', 'doe@example.com', 'John', 'Doe', False, True),
    ('bob', '$2y$10$bV/btm035m/Hv87RYB04JuTFN7opVra1zlBcvdKJHxTzBISmQeHSy', 'bob@example.com', 'Bob', 'Builder', False, False),
    ('disabled', '$2y$10$bV/btm035m/Hv87RYB04JuTFN7opVra1zlBcvdKJHxTzBISmQeHSy', 'disabled@example.com', 'Pink', 'Panther', False, False);



CREATE TABLE `QandA_Question`
(
    `id`    INT AUTO_INCREMENT NOT NULL,
    `userId` INT,
    `title` VARCHAR(255) NOT NULL,
    `content` TEXT NOT NULL,
    -- MySQL version 5.6 and higher
    -- `published` DATETIME DEFAULT CURRENT_TIMESTAMP,
    -- `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    -- `updated` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    -- MySQL version 5.5 and lower
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated` DATETIME DEFAULT NULL, --  ON UPDATE CURRENT_TIMESTAMP,
    `deleted` DATETIME DEFAULT NULL,

    PRIMARY KEY (`id`),
    FOREIGN KEY (`userId`) REFERENCES `ramverk1_User` (`id`)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;



CREATE TABLE `QandA_Awnser`
(
    `id` INT AUTO_INCREMENT NOT NULL,
    `questionId` INT NOT NULL,
    `userId` INT,
    `title` VARCHAR(255) NOT NULL,
    `accept` BOOLEAN DEFAULT FALSE,
    `content` TEXT NOT NULL,

    -- MySQL version 5.6 and higher
    -- `published` DATETIME DEFAULT CURRENT_TIMESTAMP,
    -- `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    -- `updated` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    -- MySQL version 5.5 and lower
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated` DATETIME DEFAULT NULL, --  ON UPDATE CURRENT_TIMESTAMP,
    `deleted` DATETIME DEFAULT NULL,

    PRIMARY KEY (`id`),
    FOREIGN KEY (`userId`) REFERENCES `ramverk1_User` (`id`),
    FOREIGN KEY (`questionId`) REFERENCES `QandA_Question` (`id`)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;



CREATE TABLE `QandA_Comment`
(
    `id` INT AUTO_INCREMENT NOT NULL,
    `questionId` INT NOT NULL,
    `awnserId` INT NOT NULL,
    `userId` INT,
    `title` VARCHAR(255) NOT NULL,
    `content` TEXT NOT NULL,

    -- MySQL version 5.6 and higher
    -- `published` DATETIME DEFAULT CURRENT_TIMESTAMP,
    -- `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    -- `updated` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    -- MySQL version 5.5 and lower
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated` DATETIME DEFAULT NULL, --  ON UPDATE CURRENT_TIMESTAMP,
    `deleted` DATETIME DEFAULT NULL,

    PRIMARY KEY (`id`),
    FOREIGN KEY (`userId`) REFERENCES `ramverk1_User` (`id`),
    FOREIGN KEY (`questionId`) REFERENCES `QandA_Question` (`id`),
    FOREIGN KEY (`awnserId`) REFERENCES `QandA_Awnser` (`id`)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;



CREATE TABLE `QandA_Vote`
(
    `id` INT AUTO_INCREMENT NOT NULL,
    `questionId` INT DEFAULT NULL,
    `awnserId` INT DEFAULT NULL,
    `commentId` INT DEFAULT NULL,
    `userId` INT DEFAULT NULL,
    `vote` BOOLEAN DEFAULT NULL,

    PRIMARY KEY (`id`),
    FOREIGN KEY (`userId`) REFERENCES `ramverk1_User` (`id`),
    FOREIGN KEY (`questionId`) REFERENCES `QandA_Question` (`id`),
    FOREIGN KEY (`awnserId`) REFERENCES `QandA_Awnser` (`id`),
    FOREIGN KEY (`commentId`) REFERENCES `QandA_Comment` (`id`)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;



CREATE TABLE `QandA_Tag`
(
    `id` INT AUTO_INCREMENT NOT NULL,
    `name` VARCHAR(255) NOT NULL,

    PRIMARY KEY (`id`),
    UNIQUE KEY `name_unique` (`name`)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;



CREATE TABLE `QandA_Tag2Question`
(
    `id` INT AUTO_INCREMENT NOT NULL,
    `tagId` INT NOT NULL,
    `questionId` INT NOT NULL,

    PRIMARY KEY (`id`),
    FOREIGN KEY (`tagId`) REFERENCES `QandA_Tag` (`id`),
    FOREIGN KEY (`questionId`) REFERENCES `QandA_Question` (`id`)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;


INSERT INTO ramverk1_Comment (userId, title, comment) VALUES (1, "Weeeeeeee", "Hooooo");
INSERT INTO ramverk1_Comment (userId, title, comment) VALUES (2, "Här testar Doe", "Hej Hej en rolig kommentar från John Doe.");
