SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
  time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS database_mythosmorph;

USE database_mythosmorph;

-- User Table Structure
CREATE TABLE IF NOT EXISTS `Users` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `Username` VARCHAR(80) NOT NULL,
  `Password` VARCHAR(80) NOT NULL,
  `SessionToken` TEXT,
  `SessionTokenExpireDate` TEXT,
  PRIMARY KEY (`ID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3 COLLATE = utf8mb3_general_ci;

-- WebConfig Table Structure
CREATE TABLE IF NOT EXISTS `WebConfig` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `WebsiteName` VARCHAR(80) NOT NULL,
  `WebHostName` VARCHAR(80) NOT NULL,
  `WebLogoURL` TEXT,
  `WebContact` VARCHAR(80) NOT NULL,
  `WebLauncherCompleted` ENUM('true', 'false') NOT NULL DEFAULT 'false',
  PRIMARY KEY (`ID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb3 COLLATE = utf8mb3_general_ci;

CREATE TABLE IF NOT EXISTS `Pages` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `PageContentID` BIGINT NULL,
  `Titel` VARCHAR(255) NOT NULL,
  `Meta_Description` TEXT NULL,
  `Meta_Title` VARCHAR(255) NULL,
  `Created_At` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `PageContent` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `LayoutID` BIGINT NULL,
  `Created_At` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `Layout` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `Type` ENUM("NoSplit", "2Split", "3Split")
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;

-- Initial Insert
INSERT INTO
  `WebConfig` (`ID`)
VALUES
  (1);

INSERT INTO
  `Users` (`ID`, `Username`)
VALUES
  (1, "admin");