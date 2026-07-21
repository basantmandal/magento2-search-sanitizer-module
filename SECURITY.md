# Security Policy

## Reporting a Vulnerability

We take the security of this module and its users seriously. If you discover a security vulnerability within **HK2 SearchSanitizer**, please report it privately before public disclosure.

**Please do not report security vulnerabilities through public GitHub issues.**

Send vulnerability reports to: **<support@basantmandal.in>**

We will acknowledge receipt within **48 hours** and provide an initial assessment within **5 business days**.

### What to include

- A clear description of the vulnerability
- Steps to reproduce
- Magento version and PHP version
- Any relevant configuration details
- Proof of concept (if available)

### What to expect

1. **Acknowledgment** — we confirm receipt of your report
2. **Assessment** — we evaluate the severity and impact
3. **Fix development** — we develop and test a patch
4. **Release** — we publish a fix and credit the reporter (if desired)

We aim to release security fixes within **14 days** of confirmation for critical issues.

## Supported Versions

| Version | Supported |
|---|---|
| 1.0.x | ✅ |

## Security Best Practices

When using this module:

- Always keep the module updated to the latest version
- Enable sanitization via Stores > Configuration > HK2 > Search Sanitizer
- Monitor `var/log/hk2-search-sanitizer.log` for probing attempts
- Use in conjunction with Magento's built-in security features (CSP, prepared statements, admin firewall)
- Review log retention policies for `var/log/hk2-search-sanitizer.log` in accordance with your data protection obligations
