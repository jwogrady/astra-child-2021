<!-- cSpell:words jwogrady woocommerce mysqlnd SkyVerge -->
# Astra Child 2021

**Copyright (c) 2021-2026 Status26 Inc.**
**Author:** [jwogrady](https://github.com/jwogrady)

WordPress child theme for [2021training.com](https://2021training.com), an online training/course platform.

## Tech Stack

- **Parent Theme:** Astra
- **E-commerce:** WooCommerce
- **Payment Gateway:** Authorize.Net CIM (SkyVerge)
- **LMS:** External system at class.2021training.com

## Directory Structure

```
astra-child-2021/
├── .gitignore             # Git ignore rules
├── CLAUDE.md              # Claude Code instructions
├── CHANGELOG.md           # Version history
├── README.md              # Project documentation (this file)
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

### 1. Authorize.Net Payment Fix (`functions.php:27-75`)
Fixes JavaScript dependency order for SkyVerge payment gateway. Loads jquery.payment.min.js locally and handles both old and new framework paths.

### 2. Custom Post Type: State Pages (`functions.php:80-149`)
Hierarchical CPT with slug `state` for location-specific content. Gutenberg/REST API enabled.

### 3. Custom Navigation Menus (`functions.php:151-165`)
Three menu locations: Shop, Blog, Resources.

### 4. WooCommerce Thank You Page (`woocommerce/checkout/thankyou.php`)
Custom order confirmation displaying course login credentials. Based on WooCommerce template v8.1.0.

## Production Environment

| Component | Version |
|-----------|---------|
| PHP | 8.2.29 |
| Server | LiteSpeed (CloudLinux/CentOS 8) |
| MySQL | 8.x |
| URL | https://2021training.com |

## Deployment

1. Update version in `style.css` (line 6) and `functions.php` (line 14)
2. Update `CHANGELOG.md`
3. Create ZIP excluding dev files:
   ```bash
   zip -r astra-child-2021-v1.x.x.zip . -x "*.git*" -x "CLAUDE.md" -x "CHANGELOG.md" -x ".claude/*" -x "extract/*" -x "README.md"
   ```
4. Upload to `/wp-content/themes/astra-child-2021/`

## Dependencies

| Dependency | Type | Required |
|------------|------|----------|
| Astra | Parent Theme | Yes |
| WooCommerce | Plugin | Yes |
| Authorize.Net CIM | Plugin | Yes |

## Troubleshooting

### Payment form not working
1. Check browser console for "Authorize.Net CIM scripts loaded in correct order"
2. Verify Authorize.Net plugin is active
3. Check Network tab for script load order

### Styles not applying
1. Clear all caches (browser, LiteSpeed, caching plugins)
2. Verify child theme is active
3. Check style.css loads after astra-theme-css

### State Pages not showing
1. Flush permalinks: Settings > Permalinks > Save
2. Check debug.log for PHP errors

## License

GNU General Public License v2 or later
