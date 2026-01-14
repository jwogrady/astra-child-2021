# Astra Child 2021 - Project Documentation

**Copyright (c) 2021-2026 Status26 Inc.**
**Author:** [jwogrady](https://github.com/jwogrady)

## Project Overview

WordPress child theme for [2021training.com](https://2021training.com), an online training/course platform built on:
- **Parent Theme:** Astra
- **E-commerce:** WooCommerce
- **Payment Gateway:** Authorize.Net CIM
- **LMS:** External system at class.2021training.com

## Versioning & Commits

- **Semantic Versioning:** MAJOR.MINOR.PATCH (e.g., 1.0.0)
- **Conventional Commits:** Use prefixes like `feat:`, `fix:`, `docs:`, `refactor:`, `chore:`
- **Version Location:** `style.css` header (line 5: `Version:`)

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
├── CLAUDE.md              # Project documentation
├── CHANGELOG.md           # Version history (semantic versioning)
├── style.css              # Theme header & custom CSS
├── functions.php          # Theme functions, hooks, CPTs
├── screenshot.jpg         # Theme thumbnail (1200x900)
├── js/
│   └── jquery.payment.min.js   # Payment form validation (v3.0.0)
└── woocommerce/
    └── checkout/
        └── thankyou.php   # Custom order confirmation page
```

## Key Customizations

### 1. Custom Post Type: State Pages (`functions.php:80-149`)
- Slug: `state`
- Hierarchical (supports parent/child)
- Used for location-specific content

### 2. Custom Navigation Menus (`functions.php:151-165`)
- `Shop` - Shop Categories
- `Blog` - Blog Categories
- `Resources` - Resource links

### 3. Authorize.Net Payment Fix (`functions.php:27-75`)
- Fixes JavaScript dependency order for payment gateway
- Loads jquery.payment.min.js locally
- Handles SkyVerge framework path changes between plugin versions

### 4. WooCommerce Thank You Page (`woocommerce/checkout/thankyou.php`)
- Displays course login credentials after purchase
- Links to LMS at class.2021training.com

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
3. **Merge** to master with conventional commit
4. **Tag** release: `git tag -a v1.x.x -m "Release v1.x.x"`
5. **Create ZIP** excluding dev files:
   ```bash
   zip -r astra-child-2021-v1.x.x.zip . -x "*.git*" -x "CLAUDE.md" -x "CHANGELOG.md" -x ".claude/*"
   ```
6. **Upload** via cPanel File Manager or FTP to `/wp-content/themes/astra-child-2021/`
7. **Verify** theme activation in WordPress admin

## Parent Theme & Plugin Updates

### Astra Theme Updates
- Child theme inherits from Astra via `Template: astra` in style.css
- CSS depends on `astra-theme-css` handle
- **Safe to update:** Child theme overrides persist automatically
- After Astra updates, test: homepage, checkout, state pages

### WooCommerce Updates
- Template override: `woocommerce/checkout/thankyou.php`
- **After WooCommerce updates:**
  1. Check WooCommerce changelog for template changes
  2. Compare `wp-content/plugins/woocommerce/templates/checkout/thankyou.php` with our override
  3. Merge any structural changes while preserving custom content (lines 44-50)
  4. Test complete checkout flow

### Authorize.Net Plugin Updates
- Plugin: `woocommerce-gateway-authorize-net-cim`
- Custom fix handles both old and new SkyVerge framework paths
- **After plugin updates:**
  1. Test checkout payment form loads correctly
  2. Check browser console for "Child theme: Authorize.Net scripts loaded" message
  3. If payment form breaks, check plugin file structure for path changes

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
| Authorize.Net CIM | Plugin | Payment processing |
| jQuery Payment | JS Library | Local copy in `/js/` |

## Common Tasks

### Add New Custom Post Type
1. Add registration function to `functions.php`
2. Hook to `init` action with priority 0
3. Flush permalinks: Settings > Permalinks > Save

### Override WooCommerce Template
1. Copy template from `wp-content/plugins/woocommerce/templates/`
2. Place in `woocommerce/` maintaining same subdirectory structure
3. Modify as needed, preserving WooCommerce hooks

### Update jquery.payment.js
1. Download new version from https://github.com/stripe-archive/jquery.payment
2. Replace `js/jquery.payment.min.js`
3. Update version in `functions.php:47`

## Security Notes

- Thank you page displays hardcoded temp password "tornado"
- Consider implementing dynamic password generation in future
- All user input properly escaped with WordPress functions

## Troubleshooting

### Payment form not working
1. Check browser console for JS errors
2. Verify Authorize.Net plugin is active
3. Confirm scripts load in correct order (check Network tab)

### Styles not applying
1. Clear all caches (browser, LiteSpeed, any caching plugin)
2. Verify child theme is active (not parent Astra)
3. Check style.css loads after astra-theme-css

### State Pages not showing
1. Flush permalinks
2. Verify `state_cpt()` function runs on init
3. Check for PHP errors in debug.log
