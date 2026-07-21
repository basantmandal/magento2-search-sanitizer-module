# HK2 Search Sanitizer

![Version](https://img.shields.io/badge/version-v1.0.0-blue?style=flat-square)
![License](https://img.shields.io/badge/license-OSL--3.0-green?style=flat-square)
![Magento](https://img.shields.io/badge/Magento-2.4.4%20--%202.4.9-f97316?style=flat-square&logo=magento&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1%20--%208.4-7c3aed?style=flat-square&logo=php&logoColor=white)
[![Downloads](https://img.shields.io/packagist/dt/hk2/search-sanitizer?style=flat-square)](https://packagist.org/packages/hk2/search-sanitizer)

## Overview

The HK2 Search Sanitizer module sanitizes storefront search queries by removing potentially harmful SQL-related keywords and special characters before they are processed by Magento's search engine. This helps reduce the impact of malformed or suspicious search input while preserving normal search functionality.

Potentially suspicious SQL-related keywords and characters (such as `select`,`insert`, `update`, `delete`, `drop`, `union`, `exec`, `truncate` etc.) are removed from storefront search queries. It intercepts search requests before they are processed by the query factory, ensuring that malicious strings do not affect
the database or application stability.

## 🎯 Use Cases

- **Target audience**: Magento merchants and developers who want an additional layer of search input sanitization.
- **Business problems solved**: Reduces the impact of malformed or suspicious search queries and provides visibility into modified search requests.
- **Example implementation scenarios**: Automatically sanitizes storefront search queries and logs any modifications for auditing.

## 🚀 Features

- 🛡️ Sanitizes suspicious SQL-related keywords and special characters from storefront search queries.
- 🛠 Provides configurable admin settings to enable or disable sanitization.
- 📝 Logs detected sanitized search queries for monitoring.
- 📦 Composer-installable Magento 2 module.

## 🏗 Architecture

- **Plugin**: Intercepts `Magento\Search\Model\QueryFactory::get()` before the search query is created.
- **Logging**: Uses a custom Monolog logger `HK2\SearchSanitizer\Logger\Logger` to record sanitized queries.
- **Configuration**: Exposes a toggle in the admin panel to enable or disable the sanitization globally or per store
  view.

## 🧩 Magento Components

- **Plugins**: `hk2_search_sanitizer_plugin` (`HK2\SearchSanitizer\Plugin\SearchSanitizer`)
- **Virtual Types**: `HK2\SearchSanitizer\Logger\Logger`

## 📦 Requirements

- **Magento version requirements**: Magento Open Source 2.4.4 - 2.4.9
- **Adobe Commerce compatibility**: Adobe Commerce 2.4.4 - 2.4.9
- **PHP requirements**: 8.1, 8.2, 8.3, 8.4
- **Composer requirements**: `hk2/core ^1.0`, `magento/framework ^103.0.0`

## ⚙️ Installation

1. `composer require hk2/search-sanitizer`
2. `bin/magento module:enable HK2_SearchSanitizer`
3. `bin/magento setup:upgrade`
4. `bin/magento setup:di:compile`
5. `bin/magento cache:flush`

## 🔧 Configuration

`Stores > Configuration > Search Sanitizer > General > Enable Search Sanitization`

## Usage

Once installed and enabled, the module automatically sanitizes input in the storefront search bar. If a user searches for "shoes select * from users", the query will be sanitized and processed without the SQL keywords, and a warning will be logged.

**To view the logged warnings, you can check the following log file:**
`/var/log/hk2-search-sanitizer.log`

## 📂 Module Structure

```text
.
├── composer.json
├── etc
│   ├── acl.xml
│   ├── adminhtml
│   │   ├── menu.xml
│   │   └── system.xml
│   ├── config.xml
│   ├── di.xml
│   └── module.xml
├── i18n
│   ├── en_US.csv
│   ├── hi_IN.csv
│   └── ru_RU.csv
├── Logger
│   └── Handler.php
├── Plugin
│   └── SearchSanitizer.php
├── registration.php
```

## 📈 Performance Considerations

- **Frontend performance impact**: Minimal impact, uses simple regular expressions to sanitize search strings before processing.

## 🔐 Security Considerations

- **Input validation**: Enforces strict sanitization rules on search queries to prevent SQL injection and unauthorized operations.

## Compatibility

Reference: [docs/compatibility.md](docs/compatibility.md)

| Platform                  | Supported |
|---------------------------|-----------|
| Magento Open Source 2.4.x | ✅        |
| Adobe Commerce 2.4.x      | ✅        |

## 🛠 Troubleshooting

- **Module not enabled**: Verify module status using `bin/magento module:status HK2_SearchSanitizer`.
- **Search not sanitized**: Verify that the module is enabled in the configuration (
  `Stores > Configuration > Search Sanitizer > General > Enable Search Sanitization`).

## 🤝 Contributing

Contributions are welcome! If you'd like to improve the installer:

- ⭐ **Star this repository** (Helps others find it!)
- 🍴 Fork the project
- 🐛 Report bugs
- 💡 Suggest new features
- 🤝 Contribute improvements

Every ⭐ helps increase the visibility of the project and motivates further development.

## ⚖️ Disclaimer

The author provides this installation script "as is" without any warranties. Users are responsible for ensuring that running this script complies with their internal security and software requirements.

## 🤝 Support

For bug reports, feature requests, and general support:

- **Author**: Basant Mandal
- **Email**: <support@basantmandal.in>
- **Website**: <https://www.basantmandal.in>

## License

This project is licensed under the OSL 3.0 License. See the [LICENSE.txt](LICENSE.txt) file for details.
