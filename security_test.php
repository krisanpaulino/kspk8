<?php

/**
 * Security Test Helper
 * Run this script to validate security implementations
 * WARNING: Only run this on development/testing environment
 */

// XSS Test Payloads (These should be blocked/escaped)
$xssPayloads = [
    '<script>alert("XSS")</script>',
    '"><img src=x onerror=alert("XSS")>',
    'javascript:alert("XSS")',
    '<svg onload=alert("XSS")>',
    '&lt;script&gt;alert("XSS")&lt;/script&gt;',
];

// SQL Injection Test Payloads (These should be blocked)
$sqlInjectionPayloads = [
    "' OR 1=1 --",
    "'; DROP TABLE users; --",
    "' UNION SELECT * FROM users --",
    "1' AND EXTRACTVALUE(1, CONCAT(0x7e, (SELECT user()), 0x7e)) --",
];

echo "<h1>Security Test Results</h1>";

echo "<h2>XSS Protection Test</h2>";
echo "<p>Testing XSS payload escaping...</p>";

foreach ($xssPayloads as $payload) {
    $escaped = esc($payload);
    $safe = (strpos($escaped, '<script>') === false && strpos($escaped, 'javascript:') === false);

    echo "<div style='margin: 10px; padding: 10px; border: 1px solid " . ($safe ? 'green' : 'red') . ";'>";
    echo "<strong>Payload:</strong> " . htmlspecialchars($payload) . "<br>";
    echo "<strong>Escaped:</strong> " . htmlspecialchars($escaped) . "<br>";
    echo "<strong>Status:</strong> " . ($safe ? "✅ SAFE" : "❌ VULNERABLE") . "<br>";
    echo "</div>";
}

echo "<h2>HTML Sanitization Test</h2>";
if (function_exists('sanitize_html_content')) {
    $htmlPayload = '<script>alert("XSS")</script><p>Safe content</p><img src=x onerror=alert("XSS")><strong>Bold text</strong>';
    $sanitized = sanitize_html_content($htmlPayload);

    echo "<div style='margin: 10px; padding: 10px; border: 1px solid blue;'>";
    echo "<strong>Original:</strong> " . htmlspecialchars($htmlPayload) . "<br>";
    echo "<strong>Sanitized:</strong> " . htmlspecialchars($sanitized) . "<br>";
    echo "<strong>Status:</strong> " . (strpos($sanitized, '<script>') === false ? "✅ SAFE" : "❌ VULNERABLE") . "<br>";
    echo "</div>";
} else {
    echo "<div style='color: red;'>❌ sanitize_html_content function not found!</div>";
}

echo "<h2>CSRF Protection Test</h2>";
$csrfStatus = "Unknown";
if (class_exists('Config\\Security')) {
    $security = new Config\Security();
    $csrfEnabled = $security->csrfProtection === 'cookie' || $security->csrfProtection === 'session';
    $csrfStatus = $csrfEnabled ? "✅ ENABLED" : "❌ DISABLED";
} else {
    $csrfStatus = "❌ Security config not found";
}

echo "<div style='margin: 10px; padding: 10px; border: 1px solid " . (strpos($csrfStatus, '✅') !== false ? 'green' : 'red') . ";'>";
echo "<strong>CSRF Protection:</strong> " . $csrfStatus . "<br>";
echo "</div>";

echo "<h2>Content Security Policy Test</h2>";
if (class_exists('Config\\ContentSecurityPolicy')) {
    $csp = new Config\ContentSecurityPolicy();
    $upgradeInsecure = $csp->upgradeInsecureRequests ? "✅ ENABLED" : "❌ DISABLED";

    echo "<div style='margin: 10px; padding: 10px; border: 1px solid blue;'>";
    echo "<strong>Upgrade Insecure Requests:</strong> " . $upgradeInsecure . "<br>";
    echo "</div>";
} else {
    echo "<div style='color: red;'>❌ ContentSecurityPolicy config not found!</div>";
}

echo "<h2>Filter Configuration Test</h2>";
if (class_exists('Config\\Filters')) {
    $filters = new Config\Filters();
    $beforeFilters = $filters->globals['before'] ?? [];

    $csrfFilter = in_array('csrf', $beforeFilters) ? "✅ ENABLED" : "❌ DISABLED";
    $honeypotFilter = in_array('honeypot', $beforeFilters) ? "✅ ENABLED" : "❌ DISABLED";
    $invalidCharsFilter = in_array('invalidchars', $beforeFilters) ? "✅ ENABLED" : "❌ DISABLED";

    echo "<div style='margin: 10px; padding: 10px; border: 1px solid blue;'>";
    echo "<strong>CSRF Filter:</strong> " . $csrfFilter . "<br>";
    echo "<strong>Honeypot Filter:</strong> " . $honeypotFilter . "<br>";
    echo "<strong>Invalid Chars Filter:</strong> " . $invalidCharsFilter . "<br>";
    echo "</div>";
} else {
    echo "<div style='color: red;'>❌ Filters config not found!</div>";
}

echo "<h2>Recommendations</h2>";
echo "<ul>";
echo "<li>Regularly test your application with security scanning tools</li>";
echo "<li>Keep CodeIgniter and all dependencies updated</li>";
echo "<li>Monitor application logs for suspicious activity</li>";
echo "<li>Implement proper access controls and authentication</li>";
echo "<li>Use HTTPS in production environments</li>";
echo "<li>Regularly backup your database and application files</li>";
echo "</ul>";

echo "<p><em>Note: This is a basic security test. For comprehensive security testing, use professional security tools and conduct regular security audits.</em></p>";
