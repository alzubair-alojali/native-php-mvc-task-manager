-- =============================================================================
-- SUPABASE MIGRATION: Landing Page & Contact Form Tables
-- =============================================================================
-- Run this script directly in the Supabase SQL Editor to add new tables
-- to your existing database WITHOUT affecting existing data.
-- 
-- Date: January 2026
-- =============================================================================

-- -----------------------------------------------------------------------------
-- Services Table
-- Dynamic services displayed on the landing page
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS services (
    id SERIAL PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    icon VARCHAR(50),  -- FontAwesome class (e.g., 'fa-code', 'fa-mobile')
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -----------------------------------------------------------------------------
-- Site Settings Table
-- Key-value store for editable landing page content
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS site_settings (
    id SERIAL PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -----------------------------------------------------------------------------
-- Messages Table
-- Contact form submissions from visitors
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS messages (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -----------------------------------------------------------------------------
-- Performance Indexes
-- -----------------------------------------------------------------------------
CREATE INDEX IF NOT EXISTS idx_services_created ON services(created_at);
CREATE INDEX IF NOT EXISTS idx_site_settings_key ON site_settings(setting_key);
CREATE INDEX IF NOT EXISTS idx_messages_is_read ON messages(is_read);
CREATE INDEX IF NOT EXISTS idx_messages_created ON messages(created_at);

-- -----------------------------------------------------------------------------
-- Auto-update Trigger for site_settings
-- Uses existing update_updated_at_column() function from original schema
-- -----------------------------------------------------------------------------
DROP TRIGGER IF EXISTS update_site_settings_updated_at ON site_settings;
CREATE TRIGGER update_site_settings_updated_at
    BEFORE UPDATE ON site_settings
    FOR EACH ROW
    EXECUTE FUNCTION update_updated_at_column();

-- =============================================================================
-- VERIFICATION: Check that tables were created successfully
-- =============================================================================
-- SELECT table_name FROM information_schema.tables 
-- WHERE table_schema = 'public' 
-- AND table_name IN ('services', 'site_settings', 'messages');
