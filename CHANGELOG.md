# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.1] - 2026-01-14

### Changed
- Updated `woocommerce/checkout/thankyou.php` from WooCommerce v3.7.0 to v8.1.0
- Uses `wc_get_template()` for order-received message (WooCommerce standard)
- Added clear comment markers around custom 2021Training content

## [1.0.0] - 2026-01-14

### Added
- Initial release of Astra Child 2021 theme
- Custom Post Type: State Pages (`state`) for location-specific content
- Custom navigation menu locations: Shop, Blog, Resources
- Authorize.Net CIM payment gateway JavaScript dependency fix
- Local jquery.payment.min.js (v3.0.0) for payment form validation
- WooCommerce checkout thank you page override with course login info
- Project documentation (CLAUDE.md) and changelog

### Dependencies
- Parent Theme: Astra
- WooCommerce (required)
- WooCommerce Authorize.Net CIM Gateway (required)

---

## Version History Format

### Types of Changes
- `Added` - New features
- `Changed` - Changes in existing functionality
- `Deprecated` - Soon-to-be removed features
- `Removed` - Removed features
- `Fixed` - Bug fixes
- `Security` - Vulnerability fixes

### Commit Convention
Use conventional commits when updating this changelog:
- `feat:` maps to Added
- `fix:` maps to Fixed
- `refactor:` maps to Changed
- `docs:` for documentation only (no changelog entry needed)
- `chore:` for maintenance (no changelog entry needed unless user-facing)

[Unreleased]: https://github.com/jwogrady/astra-child-2021/compare/v1.0.1...HEAD
[1.0.1]: https://github.com/jwogrady/astra-child-2021/compare/v1.0.0...v1.0.1
[1.0.0]: https://github.com/jwogrady/astra-child-2021/releases/tag/v1.0.0
