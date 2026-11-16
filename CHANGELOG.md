# Changelog

All notable changes to this project will be documented in this file.

## 1.0.0 - 2026-11-16

First release: LGPD data retention.

- Reads `retention` from laravel-lgpd `#[PersonalData]` and anonymizes each column once its own period ends, with its strategy
- `Keep` columns are nullified when retention ends (the legal duty is over)
- Period counted from `created_at` or a custom column (`HasRetentionStart`); null start never expires
- Tombstones (no personal data, keyed fingerprint): never anonymizes twice, `lgpd:retention-reapply` erases data brought back by a backup restore
- `php artisan lgpd:retention [--dry-run]`

## [Unreleased]
