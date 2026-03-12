<?php

if (!function_exists('sanitize_input')) {
    /**
     * Sanitize user input to prevent XSS attacks
     *
     * @param mixed $input
     * @return mixed
     */
    function sanitize_input($input)
    {
        if (is_array($input)) {
            return array_map('sanitize_input', $input);
        }

        if (is_string($input)) {
            // Remove null bytes
            $input = str_replace(chr(0), '', $input);

            // Trim whitespace
            $input = trim($input);

            // Convert special characters to HTML entities
            return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }

        return $input;
    }
}

if (!function_exists('sanitize_html_content')) {
    /**
     * Sanitize HTML content while preserving safe tags and CKEditor formatting
     *
     * @param string $html
     * @return string
     */
    function sanitize_html_content($html)
    {
        // Define allowed tags (expanded for CKEditor)
        $allowedTags = '<p><br><strong><b><em><i><u><h1><h2><h3><h4><h5><h6><ul><ol><li><a><img><table><tr><td><th><thead><tbody><tfoot><div><span><figure><figcaption><blockquote><pre><code><hr><mark><del><ins><sub><sup><small><big><center><font><s><strike>';

        // Strip dangerous tags first
        $html = strip_tags($html, $allowedTags);

        // Remove potentially dangerous attributes and javascript
        $html = preg_replace('/javascript:/i', '', $html);
        $html = preg_replace('/vbscript:/i', '', $html);
        $html = preg_replace('/on\w+\s*=/i', '', $html); // Remove onload, onclick, etc.

        // Allow class and id attributes (needed for CKEditor)
        // But remove data- attributes that could be dangerous
        $html = preg_replace('/data-\w+\s*=\s*["\'][^"\']*["\']/i', '', $html);

        // Sanitize style attributes - allow safe CSS properties only
        $html = preg_replace_callback('/style\s*=\s*["\']([^"\']*)["\']/i', function ($matches) {
            $style = $matches[1];
            // Allow only safe CSS properties
            $allowedProperties = [
                'color',
                'background-color',
                'font-size',
                'font-weight',
                'font-style',
                'text-decoration',
                'text-align',
                'margin',
                'padding',
                'border',
                'width',
                'height',
                'display',
                'float',
                'clear',
                'position',
                'top',
                'left',
                'right',
                'bottom',
                'line-height',
                'letter-spacing',
                'text-indent',
                'vertical-align',
                'white-space',
                'word-wrap'
            ];

            $safeStyles = [];
            $properties = explode(';', $style);
            foreach ($properties as $property) {
                $property = trim($property);
                if (empty($property)) continue;

                list($name, $value) = explode(':', $property, 2);
                $name = trim(strtolower($name));
                $value = trim($value);

                // Check if property is allowed and value doesn't contain dangerous content
                if (in_array($name, $allowedProperties) && !preg_match('/(javascript|vbscript|expression|url\s*\()/i', $value)) {
                    $safeStyles[] = $name . ':' . $value;
                }
            }

            return 'style="' . implode('; ', $safeStyles) . '"';
        }, $html);

        // Additional XSS prevention
        $html = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $html);
        $html = preg_replace('/<iframe\b[^<]*(?:(?!<\/iframe>)<[^<]*)*<\/iframe>/mi', '', $html);
        $html = preg_replace('/<object\b[^<]*(?:(?!<\/object>)<[^<]*)*<\/object>/mi', '', $html);
        $html = preg_replace('/<embed\b[^<]*(?:(?!<\/embed>)<[^<]*)*<\/embed>/mi', '', $html);

        return $html;
    }
}

if (!function_exists('validate_csrf_token')) {
    /**
     * Validate CSRF token
     *
     * @return bool
     */
    function validate_csrf_token()
    {
        $request = \Config\Services::request();
        $security = \Config\Services::security();

        $tokenName = $security->getTokenName();
        $token = $request->getPost($tokenName) ?? $request->getHeader('X-CSRF-TOKEN');

        return $security->verify($token);
    }
}

if (!function_exists('secure_redirect')) {
    /**
     * Secure redirect that validates the URL
     *
     * @param string $url
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    function secure_redirect($url)
    {
        // Validate that it's a local URL or whitelisted domain
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $parsedUrl = parse_url($url);
            $baseUrl = parse_url(base_url());

            // Only allow redirects to same domain
            if ($parsedUrl['host'] !== $baseUrl['host']) {
                return redirect()->to('/');
            }
        }

        return redirect()->to($url);
    }
}

if (!function_exists('log_security_event')) {
    /**
     * Log security events
     *
     * @param string $event
     * @param array $data
     */
    function log_security_event($event, $data = [])
    {
        $logger = \Config\Services::logger();
        $request = \Config\Services::request();

        $logData = [
            'event' => $event,
            'ip_address' => $request->getIPAddress(),
            'user_agent' => $request->getUserAgent(),
            'timestamp' => date('Y-m-d H:i:s'),
            'data' => $data
        ];

        $logger->warning('Security Event: ' . $event, $logData);
    }
}
