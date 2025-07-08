SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Datenbank anlegen
CREATE DATABASE IF NOT EXISTS `database_mythosmorph`;
USE `database_mythosmorph`;

-- Users
CREATE TABLE IF NOT EXISTS `Users` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `Username` VARCHAR(80) NOT NULL,
  `Password` VARCHAR(80) NOT NULL,
  `SessionToken` TEXT,
  `SessionTokenExpireDate` TEXT,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- WebConfig
CREATE TABLE IF NOT EXISTS `WebConfig` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `WebsiteName` VARCHAR(80) NOT NULL,
  `WebHostName` VARCHAR(80) NOT NULL,
  `WebLogoURL` TEXT,
  `WebContact` VARCHAR(80) NOT NULL,
  `WebLauncherCompleted` ENUM('true', 'false') NOT NULL DEFAULT 'false',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pages
CREATE TABLE IF NOT EXISTS `Pages` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `Titel` VARCHAR(255) NOT NULL,
  `Meta_Description` TEXT NULL,
  `Meta_Title` VARCHAR(255) NULL,
  `PathURL` VARCHAR(255) NULL,
  `Created_At` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- PageContent
CREATE TABLE IF NOT EXISTS `PageContent` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `PageID` BIGINT NOT NULL,
  `Created_At` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  CONSTRAINT FK_PageContent_Page
    FOREIGN KEY (`PageID`) REFERENCES `Pages`(`ID`)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Layout
CREATE TABLE IF NOT EXISTS `Layout` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `PageContentID` BIGINT NOT NULL,
  `Type` ENUM('NoSplitLayout', 'TwoSplitLayout', 'ThreeSplitLayout') NULL,
  `Sort` BIGINT NULL,
  PRIMARY KEY (`ID`),
  CONSTRAINT FK_Layout_PageContent
    FOREIGN KEY (`PageContentID`) REFERENCES `PageContent`(`ID`)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- NoSplitLayout
CREATE TABLE IF NOT EXISTS `NoSplitLayout` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `No1_WidgetID` BIGINT NULL,
  `No1_WidgetType` VARCHAR(80) NULL,
  PRIMARY KEY (`ID`),
  CONSTRAINT FK_NoSplitLayout_Layout
    FOREIGN KEY (`ID`) REFERENCES `Layout`(`ID`)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TwoSplitLayout
CREATE TABLE IF NOT EXISTS `TwoSplitLayout` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `No1_WidgetID` BIGINT NULL,
  `No1_WidgetType` VARCHAR(80) NULL,
  `No2_WidgetID` BIGINT NULL,
  `No2_WidgetType` VARCHAR(80) NULL,
  PRIMARY KEY (`ID`),
  CONSTRAINT FK_TwoSplitLayout_Layout
    FOREIGN KEY (`ID`) REFERENCES `Layout`(`ID`)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ThreeSplitLayout
CREATE TABLE IF NOT EXISTS `ThreeSplitLayout` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `No1_WidgetID` BIGINT NULL,
  `No1_WidgetType` VARCHAR(80) NULL,
  `No2_WidgetID` BIGINT NULL,
  `No2_WidgetType` VARCHAR(80) NULL,
  `No3_WidgetID` BIGINT NULL,
  `No3_WidgetType` VARCHAR(80) NULL,
  PRIMARY KEY (`ID`),
  CONSTRAINT FK_ThreeSplitLayout_Layout
    FOREIGN KEY (`ID`) REFERENCES `Layout`(`ID`)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Widgets
CREATE TABLE IF NOT EXISTS `TextWidget` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `Titel` TEXT NULL,
  `Content` TEXT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;

-- Initial Inserts
INSERT INTO `WebConfig`
  (`WebsiteName`, `WebHostName`, `WebLogoURL`, `WebContact`, `WebLauncherCompleted`)
VALUES
  ('My Website', 'www.example.com', '', 'contact@example.com', 'false');

INSERT INTO `Users`
  (`Username`, `Password`)
VALUES
  ('admin', 'admin');

INSERT INTO `Pages`
  (`Titel`, `PathURL`, `Meta_Description`, `Meta_Title`)
VALUES
  ('Index', 'index', 'Startseite Ihrer Website', 'Index');

-- PageContent zur Index-Page
INSERT INTO `PageContent` (`PageID`) VALUES (1);