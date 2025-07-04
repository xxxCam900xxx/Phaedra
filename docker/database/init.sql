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
  `Titel` VARCHAR(255) NOT NULL,
  `Meta_Description` TEXT NULL,
  `Meta_Title` VARCHAR(255) NULL,
  `Created_At` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- PageContent Table
CREATE TABLE IF NOT EXISTS `PageContent` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `PageID` BIGINT NOT NULL,
  `Created_At` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Layout Table
CREATE TABLE IF NOT EXISTS `Layout` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT, /* GET RIGHT LayoutID */
  `PageContentID` BIGINT NOT NULL,
  `Type` ENUM('NoSplitLayout', 'TwoSplitLayout', 'ThreeSplitLayout') NULL, /* Filter Tables */
  `Sort` BIGINT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `NoSplitLayout` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT, /* LayloutID */
  `No1_WidgetID` BIGINT NULL,
  `No1_WidgetType` VARCHAR(80) NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `TwoSplitLayout` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT, /* LayloutID */
  `No1_WidgetID` BIGINT NULL,
  `No1_WidgetType` VARCHAR(80) NULL,
  `No2_WidgetID` BIGINT NULL,
  `No2_WidgetType` VARCHAR(80) NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ThreeSplitLayout` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT, /* LayloutID */
  `No1_WidgetID` BIGINT NULL,
  `No1_WidgetType` VARCHAR(80) NULL,
  `No2_WidgetID` BIGINT NULL, /* WidgetID */
  `No2_WidgetType` VARCHAR(80) NULL, /* TablePointer */
  `No3_WidgetID` BIGINT NULL,
  `No3_WidgetType` VARCHAR(80) NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/* WIDGETS */
CREATE TABLE IF NOT EXISTS TextWidget (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `Titel` TEXT NULL,
  `Content` TEXT NULL,
  PRIMARY KEY (ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



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

-- Layout anlegen
INSERT INTO `NoSplitLayout`
  (`ID`, `No1_WidgetID`)
VALUES
  (1, NULL);

INSERT INTO `Layout` 
  (`ID`, `Type`, `Sort`)
VALUES
  (1, 'NoSplitLayout', 1);

-- Index-Page anlegen
INSERT INTO `Pages`
  (`Titel`, `Meta_Description`, `Meta_Title`)
VALUES
  ('Index', 'Startseite Ihrer Website', 'Index');