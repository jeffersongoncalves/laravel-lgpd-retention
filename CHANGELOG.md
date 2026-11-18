# Changelog

All notable changes to this project will be documented in this file.

## 2.0.0 - 2026-11-18

### Breaking

- The engine moves to [laravel-privacy](https://github.com/jeffersongoncalves/laravel-privacy), the base shared by the LGPD, GDPR, CCPA, US privacy and Quebec suites. Every class of this package keeps its name and now extends its `JeffersonGoncalves\Privacy` base. If you extend one of them, check your overrides.

### Unchanged

- Config keys, tables, migrations, commands, events and the `#[PersonalData]` declarations: apps need no change.

### Added

- Suites installed side by side (e.g. LGPD and GDPR) only see their own declarations and events.

## 1.1.0 - 2026-11-16

- Tombstones every anonymization, not only retention expiry: listens to laravel-lgpd 1.1 `PersonalDataAnonymized`, so `lgpd:retention-reapply` also erases data a backup restore brings back after a DSAR erasure.
- `Keep` columns spared by the erasure still expire with their own retention.
- Requires `jeffersongoncalves/laravel-lgpd` ^1.1.

## 1.0.0 - 2026-11-16

First release: LGPD data retention.

- Reads `retention` from laravel-lgpd `#[PersonalData]` and anonymizes each column once its own period ends, with its strategy
- `Keep` columns are nullified when retention ends (the legal duty is over)
- Period counted from `created_at` or a custom column (`HasRetentionStart`); null start never expires
- Tombstones (no personal data, keyed fingerprint): never anonymizes twice, `lgpd:retention-reapply` erases data brought back by a backup restore
- `php artisan lgpd:retention [--dry-run]`

## [Unreleased]
