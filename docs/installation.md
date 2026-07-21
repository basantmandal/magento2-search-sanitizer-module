# HK2 Search Sanitizer

## Overview

- **module purpose**: Magento 2 extension to sanitize harmful SQL keywords from search queries.
- **business value**: Enhances storefront security by stripping SQL injection vectors from user inputs.
- **key functionality**: Intercepts search queries and removes potentially malicious SQL commands, logging incidents.
- **use cases**: Protecting Magento storefronts from malicious search queries.

## 📦 Installation

### ⚙️ Install Package

```bash
composer require hk2/search-sanitizer
```

> This installs the module and its dependency `hk2/core ^1.0`.

### Step-1: Enable Module

```bash
bin/magento module:enable HK2_SearchSanitizer
```

### Step-2: Upgrade Database

```bash
bin/magento setup:upgrade
```

### Step-3: Compile

```bash
bin/magento setup:di:compile
```

### Step-4: Flush Cache

```bash
bin/magento cache:flush
```

### Step-5: Verification

1. Verify the module is enabled using `bin/magento module:status HK2_SearchSanitizer`.
2. Verify configuration settings exist in the admin panel under Search Sanitizer.
3. Test a storefront search with a SQL keyword (e.g., `test select`) and ensure it is sanitized.

## 🛠 Uninstallation

### Step-1: Disable Module

```bash
bin/magento module:disable HK2_SearchSanitizer
```

### Step-2: Remove Package

```bash
composer remove hk2/search-sanitizer
```

### Step-3: Upgrade

```bash
bin/magento setup:upgrade
```

### Step-4: Flush Cache

```bash
bin/magento cache:flush
```

### Step-5: Verification

Verify the module no longer appears in `bin/magento module:status` and its configuration section is removed from the admin panel.

## 🛠 Troubleshooting

- **Module not detected**: Verify the module is correctly installed in `app/code/HK2/SearchSanitizer` or `vendor/hk2/search-sanitizer`.
- **Composer conflicts**: Ensure your Magento instance meets the `magento/framework` version requirements.
- **Setup upgrade failures**: Check Magento system and exception logs for database or configuration errors.
- **Compilation failures**: Run `bin/magento setup:di:compile` again after removing `generated/` contents.
- **Cache issues**: Flush Redis or Varnish cache if configuration changes are not visible.
- **Permissions issues**: Verify Magento file system ownership and permissions.
- **PHP compatibility issues**: Ensure your PHP version is between 8.1 and 8.4.

## 🤝 Support

- **Author**: Basant Mandal
- **Support Email**: support@basantmandal.in
- **Website**: https://www.basantmandal.in
