# Usage Guide

## Enabling Search Sanitization

The module ships **disabled by default**. To enable it:

1. Log in to the Magento Admin Panel
2. Navigate to **Stores > Configuration > HK2 > Search Sanitizer** (or **Content > Search Sanitizer** from the admin menu)
3. Set **Enable Search Sanitization** to **Yes**
4. Click **Save Config**

Once enabled, all search queries submitted through Magento's native search will be filtered.

## What Gets Stripped

The sanitizer applies a case-insensitive `preg_replace` to remove the following patterns:

| Pattern | Example input | Sanitized output |
|---|---|---|
| `SELECT` | `SELECT * FROM products` | `* FROM products` |
| `INSERT` | `INSERT INTO users` | `INTO users` |
| `UPDATE` | `UPDATE SET price=0` | `SET price=0` |
| `DELETE` | `'; DELETE FROM users` | `''` |
| `DROP` | `product DROP TABLE` | `product TABLE` |
| `UNION` | `union select 1` | `1` |
| `;` (semicolon) | `admin'; DROP` | `admin' DROP` |
| `--` (comment) | `admin'--` | `admin'` |
| `#` (hash comment) | `admin#foo` | `adminfoo` |

### Important behavioral notes

- **Substring matching** — the regex matches the keyword anywhere in the string. For example, `selective` becomes `ive` because it contains `select`. This is intentional: the filter errs on the side of removing potential threats.
- **Multiple passes** — if a query contains multiple keywords, all are stripped in a single pass.
- **Whitespace preserved** — the result is trimmed after the regex replacement.

## Logging

Every time a query is sanitized (i.e., the output differs from the input), the event is logged.

**Log file:** `var/log/sanitizer.log` (relative to Magento root)

**Log level:** WARNING

**Logged information:**

```
[2026-05-11T10:30:00.123456+00:00] search-sanitizer.WARNING: Sanitized search query detected {"original":"admin'; DROP TABLE users --","sanitized":"admin' TABLE users "} []
```

Each entry contains:
- Timestamp
- Log level (WARNING)
- Message: "Sanitized search query detected"
- Context: JSON object with `original` (raw query) and `sanitized` (cleaned query)

### Viewing the log

```bash
tail -f var/log/sanitizer.log
```

Search for sanitization events:

```bash
grep "Sanitized search query" var/log/sanitizer.log
```

## Disabling the Sanitizer

Set **Enable Search Sanitization** back to **No** in the admin configuration and save. The plugin remains loaded via `di.xml` but returns the query unchanged without processing.

## Best Practices

1. **Test before enabling in production** — enable in a staging environment first and verify behavior with your store's typical search queries.
2. **Monitor the log file** — periodically review `var/log/sanitizer.log` for probing attempts. An unusually high number of sanitization events may indicate an automated attack.
3. **Combine with other security measures** — use as part of a layered security strategy alongside CSP, WAF, access controls, and regular security patches.
4. **Log retention** — configure log rotation for `var/log/sanitizer.log`:

   ```
   /path/to/magento/var/log/sanitizer.log {
       daily
       rotate 30
       compress
       missingok
       notifempty
   }
   ```

5. **Review for false positives** — if customers report unexpected search results (e.g., "selective" returns no results), the sanitizer may be responsible. Consider whether the trade-off is acceptable for your store.
6. **Keep the module updated** — follow the [GitHub repository](https://github.com/basantmandal/magento2-search-sanitizer-module) for updates.

## Defense-in-Context

This module provides **defense-in-depth** sanitization at the input boundary. It is not a replacement for:

- Prepared statements and parameterized queries (already used by Magento's ORM)
- Proper database permissions and least-privilege access
- Web application firewall (WAF) rules
- Regular security patching and updates

The sanitizer complements these layers by catching SQL keywords at the earliest possible point — before they reach the ORM pipeline — and alerting operators via the log when probes are detected.
