SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Datenbank anlegen
CREATE DATABASE IF NOT EXISTS `database_mythosmorph`;
USE `database_mythosmorph`;

-- User Table Structure
CREATE TABLE IF NOT EXISTS `Users` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `Username` VARCHAR(80) NOT NULL,
  `Password` VARCHAR(80) NOT NULL,
  `SessionToken` TEXT,
  `SessionTokenExpireDate` TEXT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- WebConfig Table Structure
CREATE TABLE IF NOT EXISTS `WebConfig` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `WebsiteName` VARCHAR(80) NOT NULL,
  `WebHostName` VARCHAR(80) NOT NULL,
  `WebLogoURL` TEXT,
  `WebContact` VARCHAR(80) NOT NULL,
  `WebLauncherCompleted` ENUM('true', 'false') NOT NULL DEFAULT 'false',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pages Table
CREATE TABLE IF NOT EXISTS `Pages` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `PageContentID` BIGINT NULL,
  `Titel` VARCHAR(255) NOT NULL,
  `Meta_Description` TEXT NULL,
  `Meta_Title` VARCHAR(255) NULL,
  `Created_At` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- PageContent Table
CREATE TABLE IF NOT EXISTS `PageContent` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `LayoutID` BIGINT NULL,
  `Created_At` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Layout Table
CREATE TABLE IF NOT EXISTS `Layout` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `Type` ENUM('NoSplit', '2Split', '3Split') NOT NULL DEFAULT 'NoSplit',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;

-- Initial Insert: WebConfig
INSERT INTO `WebConfig`
  (`WebsiteName`, `WebHostName`, `WebLogoURL`, `WebContact`, `WebLauncherCompleted`)
VALUES
  ('My Website', 'www.example.com', '', 'contact@example.com', 'false');

-- Initial Insert: Admin User
INSERT INTO `Users`
  (`Username`, `Password`)
VALUES
  ('admin', 'admin');

  -- PageContent für Index erstellen
INSERT INTO `PageContent` (`LayoutID`)
VALUES (NULL);

-- Letzte PageContent-ID merken
SET @PageContentID = LAST_INSERT_ID();

-- Index-Page anlegen
INSERT INTO `Pages`
  (`PageContentID`, `Titel`, `Meta_Description`, `Meta_Title`)
VALUES
  (@PageContentID, 'Index', 'Startseite Ihrer Website', 'Index');
