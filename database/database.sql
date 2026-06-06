-- ===========================================
-- KCSC Database Schema
-- ===========================================
-- Run this file to set up the database:
--   mysql -u root -p < database/database.sql
-- Or import via phpMyAdmin.

-- Create the database
CREATE DATABASE IF NOT EXISTS `kcsc_db`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `kcsc_db`;

-- ===========================================
-- Table: applications
-- Stores club membership applications
-- ===========================================
CREATE TABLE IF NOT EXISTS `applications` (
    `id`          INT UNSIGNED    AUTO_INCREMENT PRIMARY KEY,
    `full_name`   VARCHAR(100)    NOT NULL,
    `email`       VARCHAR(255)    NOT NULL,
    `student_id`  VARCHAR(20)     NOT NULL,
    `department`  VARCHAR(50)     NOT NULL,
    `phone`       VARCHAR(20)     NOT NULL,
    `interest`    TEXT            NULL      COMMENT 'Why they are interested in cybersecurity',
    `image_url`   VARCHAR(255)    NULL,
    `created_at`  TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,

    -- Unique constraints to prevent duplicate registrations
    UNIQUE KEY `uk_email`      (`email`),
    UNIQUE KEY `uk_student_id` (`student_id`),

    -- Indexes for fast lookups
    INDEX `idx_department`     (`department`),
    INDEX `idx_created_at`     (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===========================================
-- Table: members
-- Stores approved club members
-- ===========================================
CREATE TABLE IF NOT EXISTS `members` (
    `id`          INT UNSIGNED    AUTO_INCREMENT PRIMARY KEY,
    `full_name`   VARCHAR(100)    NOT NULL,
    `email`       VARCHAR(255)    NOT NULL,
    `student_id`  VARCHAR(20)     NOT NULL,
    `department`  VARCHAR(50)     NOT NULL,
    `phone`       VARCHAR(20)     NOT NULL,
    `role`        VARCHAR(100)    NOT NULL,
    `image_url`   VARCHAR(255)    NULL,
    `joined_at`   TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,

    -- Unique constraints
    UNIQUE KEY `uk_email`      (`email`),
    UNIQUE KEY `uk_student_id` (`student_id`),

    -- Indexes
    INDEX `idx_department`     (`department`),
    INDEX `idx_joined_at`      (`joined_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===========================================
-- Table: events
-- Stores club events and their dates
-- ===========================================
CREATE TABLE IF NOT EXISTS `events` (
    `id`          INT UNSIGNED    AUTO_INCREMENT PRIMARY KEY,
    `title`       VARCHAR(255)    NOT NULL,
    `description` TEXT            NOT NULL,
    `event_date`  DATE            NOT NULL,
    `created_at`  TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    
    INDEX `idx_event_date` (`event_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===========================================
-- Table: notices
-- Stores club notices and announcements
-- ===========================================
CREATE TABLE IF NOT EXISTS `notices` (
    `id`          INT UNSIGNED    AUTO_INCREMENT PRIMARY KEY,
    `title`       VARCHAR(255)    NOT NULL,
    `content`     TEXT            NOT NULL,
    `created_at`  TIMESTAMP       DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
