<!-- cSpell:words jwogrady woocommerce mysqlnd SkyVerge -->
# Claude Code Instructions

**Project:** Astra Child 2021 - WordPress child theme for 2021training.com
**Copyright (c) 2021-2026 Status26 Inc.**
**Author:** [jwogrady](https://github.com/jwogrady)

## Versioning Rules

**ALWAYS use Semantic Versioning and Conventional Commits.**

- **Semantic Versioning:** MAJOR.MINOR.PATCH (e.g., 1.0.0)
- **Conventional Commits:** `feat:`, `fix:`, `docs:`, `refactor:`, `chore:`
- **Version Locations:**
  - `style.css` line 6: `Version:`
  - `functions.php` line 14: `CHILD_THEME_ASTRA_CHILD_2021_VERSION`

### Commit Examples
```
feat: add new custom post type for testimonials
fix: resolve Authorize.Net script loading on checkout
docs: update CHANGELOG for v1.1.0
refactor: optimize payment gateway dependency chain
chore: bump version to 1.1.0
```

## Critical File References

| File | Lines | Purpose |
|------|-------|---------|
| `functions.php` | 27-75 | Authorize.Net payment fix |
| `functions.php` | 80-149 | State Pages CPT |
| `functions.php` | 151-165 | Custom navigation menus |
| `woocommerce/checkout/thankyou.php` | 44-50 | Custom login credentials |

## Extract Directory

The `extract/` directory (git-ignored) contains plugin source files for reference:

| Directory | Purpose |
|-----------|---------|
| `woocommerce-gateway-authorize-net-cim/` | Authorize.Net plugin - verify JS paths against `functions.php:35-37` |
| `woocommerce/` | WooCommerce templates - compare with theme overrides |
| `woocommerce-2021training/` | Custom LMS enrollment plugin |

**Keep extract/ in sync** with production plugin versions to ensure child theme compatibility.

## Common Tasks

### Version Bump
1. Update `style.css` line 6
2. Update `functions.php` line 14
3. Update `CHANGELOG.md`
4. Commit: `chore: bump version to X.X.X`

### Update WooCommerce Template
1. Compare `extract/woocommerce/templates/checkout/thankyou.php` with child theme version
2. Merge structural changes, preserve custom content (lines 44-50)
3. Note `@version` in template header

### Update jquery.payment.js
1. Download from https://github.com/stripe-archive/jquery.payment
2. Replace `js/jquery.payment.min.js`
3. Update version in `functions.php:47`

## Plugin Update Checks

### After Authorize.Net Updates
1. Update `extract/woocommerce-gateway-authorize-net-cim/`
2. Check browser console for "Authorize.Net CIM scripts loaded in correct order"
3. If broken, check `functions.php:35-37` paths against new plugin structure

### After WooCommerce Updates
1. Check template changelog for `thankyou.php` changes
2. Compare and merge if needed (preserve lines 44-50)

## Testing Checklist

- [ ] Homepage loads
- [ ] State Pages CPT works
- [ ] Navigation menus render
- [ ] Checkout payment form works
- [ ] Thank you page shows login info

## Security Note

`thankyou.php:48` contains hardcoded password "tornado" - consider dynamic generation.

## WordPress Standards

- Use `get_stylesheet_directory_uri()` for child theme assets
- Enqueue styles with `astra-theme-css` dependency
- Hook priorities: styles=15, scripts=5
- Text domain: `astra-child-2021`
