<!-- cSpell:words jwogrady woocommerce mysqlnd SkyVerge -->
# Astra Child 2021 - Project Documentation

**Copyright (c) 2021-2026 Status26 Inc.**
**Author:** [jwogrady](https://github.com/jwogrady)

## Project Overview

WordPress child theme for [2021training.com](https://2021training.com), an online training/course platform built on:
- **Parent Theme:** Astra
- **E-commerce:** WooCommerce
- **Payment Gateway:** Authorize.Net CIM (SkyVerge)
- **LMS:** External system at class.2021training.com

## Versioning & Commits

**ALWAYS use Semantic Versioning and Conventional Commits for this project.**

- **Semantic Versioning:** ALWAYS use MAJOR.MINOR.PATCH format (e.g., 1.0.0)
- **Conventional Commits:** ALWAYS use prefixes: `feat:`, `fix:`, `docs:`, `refactor:`, `chore:`
- **Version Location:** `style.css` header (line 6: `Version:`)
- **Changelog:** Update `CHANGELOG.md` for user-facing changes

### Commit Examples
```
feat: add new custom post type for testimonials
fix: resolve Authorize.Net script loading on checkout
docs: update CHANGELOG for v1.1.0
refactor: optimize payment gateway dependency chain
chore: update jquery.payment.min.js to v3.1.0
```

## Directory Structure

```
astra-child-2021/
├── .gitignore             # Git ignore rules
├── CLAUDE.md              # Project documentation (this file)
├── CHANGELOG.md           # Version history (Keep a Changelog format)
├── style.css              # Theme header & custom CSS
├── functions.php          # Theme functions, hooks, CPTs
├── screenshot.jpg         # Theme thumbnail (1200x900)
├── js/
│   └── jquery.payment.min.js   # Payment form validation (v3.0.0)
└── woocommerce/
    └── checkout/
        └── thankyou.php   # Custom order confirmation page
```

## Extract Directory (Development Reference)

The `extract/` directory (git-ignored) contains source plugin/template files used as reference for maintaining consistency in child theme overrides and customizations:

```
extract/
├── woocommerce-gateway-authorize-net-cim/   # Authorize.Net CIM plugin (SkyVerge)
├── woocommerce/                              # Latest WooCommerce plugin source
└── woocommerce-2021training/                 # Custom plugin: adds users to LMS on purchase
```

### Purpose
- **woocommerce-gateway-authorize-net-cim**: Reference for payment gateway JS paths and SkyVerge framework structure. Used to verify script loading fixes in `functions.php:27-75`.
- **woocommerce**: Source templates for WooCommerce overrides. Compare `templates/checkout/thankyou.php` with child theme version when updating.
- **woocommerce-2021training**: Custom plugin that handles user enrollment in LMS (class.2021training.com) after purchase.

### Keeping Files Consistent
When updating plugins on production, update the corresponding `extract/` folder locally to maintain accurate reference copies. This ensures child theme overrides remain compatible with current plugin versions.

## Key Customizations

### 1. Authorize.Net Payment Fix (`functions.php:27-75`)
- Fixes JavaScript dependency order for payment gateway
- Loads jquery.payment.min.js locally from `/js/` directory
- Handles both old and new SkyVerge framework paths
- Console confirmation: "Authorize.Net CIM scripts loaded in correct order"

### 2. Custom Post Type: State Pages (`functions.php:80-149`)
- Slug: `state`
- Hierarchical (supports parent/child)
- Used for location-specific content
- Gutenberg/REST API enabled

### 3. Custom Navigation Menus (`functions.php:151-165`)
- `Shop` - Shop Categories
- `Blog` - Blog Categories
- `Resources` - Resource links

### 4. WooCommerce Thank You Page (`woocommerce/checkout/thankyou.php`)
- Custom content at lines 44-50
- Displays course login credentials after purchase
- Links to LMS at class.2021training.com
- Based on WooCommerce template version 3.7.0

## Production Environment

| Component | Version/Details |
|-----------|----------------|
| PHP | 8.2.29 |
| Server | LiteSpeed (CloudLinux/CentOS 8) |
| Hosting | WHM/cPanel |
| MySQL | 8.x (mysqlnd 8.2.29) |
| Memory Limit | 512M |
| URL | https://2021training.com |

## Deployment Workflow

1. **Develop** on feature branch
2. **Test** locally or on staging
3. **Update version** in `style.css` (line 6) and `functions.php` (line 14)
4. **Update CHANGELOG.md** with changes
5. **Merge** to master with conventional commit
6. **Tag** release: `git tag -a v1.x.x -m "Release v1.x.x"`
7. **Create ZIP** excluding dev files:
   ```bash
   zip -r astra-child-2021-v1.x.x.zip . -x "*.git*" -x "CLAUDE.md" -x "CHANGELOG.md" -x ".claude/*" -x "extract/*"
   ```
8. **Upload** via cPanel File Manager or FTP to `/wp-content/themes/astra-child-2021/`
9. **Verify** theme activation in WordPress admin

## Parent Theme & Plugin Updates

### Astra Theme Updates
- Child theme inherits from Astra via `Template: astra` in style.css
- CSS depends on `astra-theme-css` handle
- **Safe to update:** Child theme overrides persist automatically
- After Astra updates, test: homepage, checkout, state pages

### WooCommerce Updates
- Template override: `woocommerce/checkout/thankyou.php` (based on v3.7.0)
- **After WooCommerce updates:**
  1. Check WooCommerce changelog for template changes
  2. Compare `extract/woocommerce/templates/checkout/thankyou.php` with child theme version
  3. Merge any structural changes while preserving custom content (lines 44-50)
  4. Test complete checkout flow

### Authorize.Net Plugin Updates
- Plugin: `woocommerce-gateway-authorize-net-cim`
- Custom fix handles both old and new SkyVerge framework paths
- **After plugin updates:**
  1. Update `extract/woocommerce-gateway-authorize-net-cim/` with new plugin version
  2. Test checkout payment form loads correctly
  3. Check browser console for "Authorize.Net CIM scripts loaded in correct order" message
  4. If payment form breaks, check plugin file structure for path changes

## Testing Checklist

Before each release:
- [ ] Homepage loads correctly
- [ ] State Pages CPT displays properly
- [ ] All navigation menus render
- [ ] WooCommerce shop/product pages work
- [ ] Checkout payment form accepts card input
- [ ] Payment processes successfully (use test mode)
- [ ] Thank you page shows custom login info
- [ ] Mobile responsive layout intact

## Dependencies

| Dependency | Type | Notes |
|------------|------|-------|
| Astra | Parent Theme | Required - do not deactivate |
| WooCommerce | Plugin | Core e-commerce functionality |
| Authorize.Net CIM | Plugin | Payment processing (SkyVerge) |
| jQuery Payment | JS Library | Local copy in `/js/` (v3.0.0) |

## Common Tasks

### Add New Custom Post Type
1. Add registration function to `functions.php`
2. Hook to `init` action with priority 0
3. Include `'show_in_rest' => true` for Gutenberg support
4. Flush permalinks: Settings > Permalinks > Save

### Override WooCommerce Template
1. Copy template from `extract/woocommerce/templates/` (or download from plugin)
2. Place in `woocommerce/` maintaining same subdirectory structure
3. Modify as needed, preserving WooCommerce hooks
4. Note the `@version` in template header for future compatibility checks

### Update jquery.payment.js
1. Download new version from https://github.com/stripe-archive/jquery.payment
2. Replace `js/jquery.payment.min.js`
3. Update version in `functions.php:47`

### Version Bump
1. Update `style.css` line 6: `Version: X.X.X`
2. Update `functions.php` line 14: `CHILD_THEME_ASTRA_CHILD_2021_VERSION`
3. Update `CHANGELOG.md` with changes
4. Commit with `chore: bump version to X.X.X`

## Security Notes

- Thank you page displays hardcoded temp password "tornado" (line 48)
- Consider implementing dynamic password generation in future
- All user input properly escaped with WordPress functions

## Troubleshooting

### Payment form not working
1. Check browser console for JS errors
2. Look for "Authorize.Net CIM scripts loaded in correct order" message
3. Verify Authorize.Net plugin is active
4. Confirm scripts load in correct order (check Network tab)
5. Compare `extract/woocommerce-gateway-authorize-net-cim/` paths with `functions.php:35-37`

### Styles not applying
1. Clear all caches (browser, LiteSpeed, any caching plugin)
2. Verify child theme is active (not parent Astra)
3. Check style.css loads after astra-theme-css
4. Verify version constant in functions.php matches style.css

### State Pages not showing
1. Flush permalinks: Settings > Permalinks > Save
2. Verify `state_cpt()` function runs on init
3. Check for PHP errors in debug.log

## WordPress Child Theme Standards

This theme follows WordPress child theme best practices:
- **Theme Header:** Complete header in `style.css` with Template declaration
- **Functions:** Uses `get_stylesheet_directory_uri()` for child theme assets
- **Enqueuing:** Properly enqueues styles with parent dependency (`astra-theme-css`)
- **Hooks:** Uses appropriate action priorities (styles: 15, scripts: 5)
- **Text Domain:** `astra-child-2021` for internationalization
- **License:** GPL v2 or later

### References
- [WordPress Child Themes](https://developer.wordpress.org/themes/advanced-topics/child-themes/)
- [Astra Child Theme Guide](https://developer.wordpress.org/themes/basics/theme-functions/)
- [WooCommerce Template Structure](https://docs.woocommerce.com/document/template-structure/)
