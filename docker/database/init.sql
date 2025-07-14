SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
  time_zone = "+00:00";

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
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- WebConfig
CREATE TABLE IF NOT EXISTS `WebConfig` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `WebsiteName` VARCHAR(80) NOT NULL,
  `WebHostName` VARCHAR(80) NOT NULL,
  `WebLogoURL` TEXT,
  `WebContact` VARCHAR(80) NOT NULL,
  `WebLauncherCompleted` ENUM('true', 'false') NOT NULL DEFAULT 'false',
  PRIMARY KEY (`ID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Media Folder
CREATE TABLE IF NOT EXISTS `Media` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `MediaURL` TEXT NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Webdesign
CREATE TABLE IF NOT EXISTS `WebDesign` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `Primary_Color` VARCHAR(80) NULL,
  `Secondary_Color` VARCHAR(80) NULL,
  `Background_Color` VARCHAR(80) NULL,
  `Footer_Color` VARCHAR(80) NULL,
  `Heading1_Size` VARCHAR(80) NULL,
  `Heading2_Size` VARCHAR(80) NULL,
  `Paragraph_Size` VARCHAR(80) NULL,
  `Heading1_Weight` VARCHAR(80) NULL,
  `Heading2_Weight` VARCHAR(80) NULL,
  `Paragraph_Weight` VARCHAR(80) NULL,
  `Link_Color` VARCHAR(80) NULL,
  `LinkHover_Color` VARCHAR(80) NULL,
  PRIMARY KEY (`ID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Pages
CREATE TABLE IF NOT EXISTS `Pages` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `Nav_Title` VARCHAR(255) NOT NULL,
  `Page_Title` VARCHAR(255) NULL,
  `Meta_Description` TEXT NULL,
  `PathURL` VARCHAR(255) NULL,
  `Sort` BIGINT NULL,
  `Created_At` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- PageContent
CREATE TABLE IF NOT EXISTS `PageContent` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `PageID` BIGINT NOT NULL,
  `Created_At` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  CONSTRAINT FK_PageContent_Page FOREIGN KEY (`PageID`) REFERENCES `Pages`(`ID`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Layout
CREATE TABLE IF NOT EXISTS `Layout` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `PageContentID` BIGINT NOT NULL,
  `Type` ENUM(
    'NoSplitLayout',
    'TwoSplitLayout',
    'ThreeSplitLayout',
    'BigRightSplitLayout',
    'BigLeftSplitLayout'
  ) NULL,
  `Sort` BIGINT NULL,
  PRIMARY KEY (`ID`),
  CONSTRAINT FK_Layout_PageContent FOREIGN KEY (`PageContentID`) REFERENCES `PageContent`(`ID`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- NoSplitLayout
CREATE TABLE IF NOT EXISTS `NoSplitLayout` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `No1_WidgetID` BIGINT NULL,
  `No1_WidgetType` VARCHAR(80) NULL,
  PRIMARY KEY (`ID`),
  CONSTRAINT FK_NoSplitLayout_Layout FOREIGN KEY (`ID`) REFERENCES `Layout`(`ID`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- TwoSplitLayout
CREATE TABLE IF NOT EXISTS `TwoSplitLayout` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `No1_WidgetID` BIGINT NULL,
  `No1_WidgetType` VARCHAR(80) NULL,
  `No2_WidgetID` BIGINT NULL,
  `No2_WidgetType` VARCHAR(80) NULL,
  PRIMARY KEY (`ID`),
  CONSTRAINT FK_TwoSplitLayout_Layout FOREIGN KEY (`ID`) REFERENCES `Layout`(`ID`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

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
  CONSTRAINT FK_ThreeSplitLayout_Layout FOREIGN KEY (`ID`) REFERENCES `Layout`(`ID`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- BigLeftSplitLayout
CREATE TABLE IF NOT EXISTS `BigLeftSplitLayout` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `No1_WidgetID` BIGINT NULL,
  `No1_WidgetType` VARCHAR(80) NULL,
  `No2_WidgetID` BIGINT NULL,
  `No2_WidgetType` VARCHAR(80) NULL,
  PRIMARY KEY (`ID`),
  CONSTRAINT FK_BigLeftSplit_Layout FOREIGN KEY (`ID`) REFERENCES `Layout`(`ID`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- BigRightSplitLayout
CREATE TABLE IF NOT EXISTS `BigRightSplitLayout` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `No1_WidgetID` BIGINT NULL,
  `No1_WidgetType` VARCHAR(80) NULL,
  `No2_WidgetID` BIGINT NULL,
  `No2_WidgetType` VARCHAR(80) NULL,
  PRIMARY KEY (`ID`),
  CONSTRAINT FK_BigRightSplit_Layout FOREIGN KEY (`ID`) REFERENCES `Layout`(`ID`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Widgets
CREATE TABLE IF NOT EXISTS `TextWidget` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `Titel` TEXT NULL,
  `Content` TEXT NULL,
  PRIMARY KEY (`ID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ImageWidget` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `ImageURL` TEXT NULL,
  `ImageDesc` TEXT NULL,
  PRIMARY KEY (`ID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `RepoCrawlerWidget` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `ForgejoURL` TEXT NULL,
  `ForgejoUsername` TEXT NULL,
  `GithubUsername` TEXT NULL,
  PRIMARY KEY (`ID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Widget
CREATE TABLE IF NOT EXISTS `FaqWidget` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Backend Questions
CREATE TABLE IF NOT EXISTS `Faqs` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `Question` TEXT NULL,
  `Answer` TEXT NULL,
  `IsShown` ENUM('true', 'false') NOT NULL DEFAULT 'false',
  `Created_At` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- TextTyping Widget
CREATE TABLE IF NOT EXISTS `TextTypingWidget` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `RotationText` TEXT NULL,
  `Content` TEXT NULL,
  PRIMARY KEY (`ID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Video Widget
CREATE TABLE IF NOT EXISTS `VideoWidget` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `VideoURL` TEXT NULL,
  `VideoDesc` TEXT NULL,
  PRIMARY KEY (`ID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Social Widget
CREATE TABLE IF NOT EXISTS `SocialWidget` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Backend Social
CREATE TABLE IF NOT EXISTS `Socials` (
  `ID` BIGINT NOT NULL AUTO_INCREMENT,
  `Icon` TEXT NULL,
  `SocialURL` TEXT NULL,
  `IsShown` ENUM('true', 'false') NOT NULL DEFAULT 'false',
  `Created_At` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

COMMIT;

-- Initial Inserts
INSERT INTO
  `WebConfig` (
    `WebsiteName`,
    `WebHostName`,
    `WebLogoURL`,
    `WebContact`,
    `WebLauncherCompleted`
  )
VALUES
  (
    'My Website',
    'www.example.com',
    '',
    'contact@example.com',
    'false'
  );

INSERT INTO
  `Users` (`Username`, `Password`)
VALUES
  ('admin', 'admin');

INSERT INTO
  `Pages` (
    `Nav_Title`,
    `PathURL`,
    `Meta_Description`,
    `Page_Title`,
    `Sort`
  )
VALUES
  (
    'Startseite',
    'index',
    'Startseite Ihrer Website',
    'Index',
    0
  );

-- PageContent zur Index-Page
INSERT INTO
  `PageContent` (`PageID`)
VALUES
  (1);

-- Standardwerte für Webseite
INSERT INTO `WebDesign` (
  `Primary_Color`,
  `Secondary_Color`,
  `Background_Color`,
  `Footer_Color`,
  `Heading1_Size`,
  `Heading2_Size`,
  `Paragraph_Size`,
  `Heading1_Weight`,
  `Heading2_Weight`,
  `Paragraph_Weight`,
  `Link_Color`,
  `LinkHover_Color`
) VALUES (
  '#616161',        
  '#969696',        
  '#FFFFFF',        
  '#2E2E2E',        
  '36',             
  '28',             
  '18',             
  '700',            
  '600',            
  '400',            
  '#FFFFFF',        
  '#123456'         
);

INSERT INTO
  `Faqs` (`Question`, `Answer`, `IsShown`)
VALUES
  ("Test1", "Antowrt1", "true"),
  ("Test2", "Antowrt2", "false"),
  ("Test3", "Antowrt3", "true");