<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Stores the default settings for the ContentSecurityPolicy, if you
 * choose to use it. The values here will be read in and set as defaults
 * for the site. If needed, they can be overridden on a page-by-page basis.
 *
 * Suggested reference for explanations:
 *
 * @see https://www.html5rocks.com/en/tutorials/security/content-security-policy/
 */
class ContentSecurityPolicy extends BaseConfig
{
    // -------------------------------------------------------------------------
    // Broadbrush CSP management
    // -------------------------------------------------------------------------

    /**
     * Default CSP report context
     */
    public bool $reportOnly = false;

    /**
     * Specifies a URL where a browser will send reports
     * when a content security policy is violated.
     */
    public ?string $reportURI = null;

    /**
     * Instructs user agents to rewrite URL schemes, changing
     * HTTP to HTTPS. This directive is for websites with
     * large numbers of old URLs that need to be rewritten.
     */
    public bool $upgradeInsecureRequests = true;

    // -------------------------------------------------------------------------
    // Sources allowed
    // NOTE: once you set a policy to 'none', it cannot be further restricted
    // -------------------------------------------------------------------------

    /**
     * Will default to self if not overridden
     *
     * @var list<string>|string|null
     */
    public $defaultSrc = 'self';

    /**
     * Lists allowed scripts' URLs.
     *
     * @var list<string>|string
     */
    public $scriptSrc = [
        'self',
        'https://code.jquery.com',
        'https://cdn.jsdelivr.net',
        'https://cdnjs.cloudflare.com',
        'https://stackpath.bootstrapcdn.com',
        'https://unpkg.com',
        'https://ajax.googleapis.com',
        'https://cdn.datatables.net',
        'https://maxcdn.bootstrapcdn.com',
        'unsafe-inline', // Required for some legacy inline scripts - use sparingly
    ];

    /**
     * Lists allowed stylesheets' URLs.
     *
     * @var list<string>|string
     */
    public $styleSrc = [
        'self',
        'https://fonts.googleapis.com',
        'https://cdn.jsdelivr.net',
        'https://cdnjs.cloudflare.com',
        'https://stackpath.bootstrapcdn.com',
        'https://unpkg.com',
        'https://maxcdn.bootstrapcdn.com',
        'https://cdn.datatables.net',
        'unsafe-inline', // Required for inline styles - be cautious
    ];

    /**
     * Defines the origins from which images can be loaded.
     *
     * @var list<string>|string
     */
    public $imageSrc = [
        'self',
        'data:', // Allow base64 encoded images
        'https:', // Allow all HTTPS images
        'https://cdn.jsdelivr.net',
        'https://cdnjs.cloudflare.com',
        'https://stackpath.bootstrapcdn.com',
        'https://unpkg.com',
        'https://via.placeholder.com', // Placeholder images
    ];

    /**
     * Restricts the URLs that can appear in a page's `<base>` element.
     *
     * Will default to self if not overridden
     *
     * @var list<string>|string|null
     */
    public $baseURI = 'self';

    /**
     * Lists the URLs for workers and embedded frame contents
     *
     * @var list<string>|string
     */
    public $childSrc = [
        'self',
        'https://www.youtube.com', // YouTube embeds
        'https://player.vimeo.com', // Vimeo embeds
        'https://www.google.com', // Google Maps, etc.
    ];

    /**
     * Limits the origins that you can connect to (via XHR,
     * WebSockets, and EventSource).
     *
     * @var list<string>|string
     */
    public $connectSrc = [
        'self',
        'https:', // Allow HTTPS connections
        'wss:', // Allow secure WebSocket connections
        'https://api.github.com', // GitHub API
        'https://cdn.jsdelivr.net',
        'https://cdnjs.cloudflare.com',
    ];

    /**
     * Specifies the origins that can serve web fonts.
     *
     * @var list<string>|string
     */
    public $fontSrc = [
        'self',
        'https://fonts.gstatic.com',
        'https://fonts.googleapis.com',
        'https://cdn.jsdelivr.net',
        'https://cdnjs.cloudflare.com',
        'https://stackpath.bootstrapcdn.com',
        'https://unpkg.com',
        'data:', // Allow base64 encoded fonts
    ];

    /**
     * Lists valid endpoints for submission from `<form>` tags.
     *
     * @var list<string>|string
     */
    public $formAction = 'self';

    /**
     * Specifies the sources that can embed the current page.
     * This directive applies to `<frame>`, `<iframe>`, `<embed>`,
     * and `<applet>` tags. This directive can't be used in
     * `<meta>` tags and applies only to non-HTML resources.
     *
     * @var list<string>|string|null
     */
    public $frameAncestors = 'self';

    /**
     * The frame-src directive restricts the URLs which may
     * be loaded into nested browsing contexts.
     *
     * @var list<string>|string|null
     */
    public $frameSrc = [
        'self',
        'https://www.youtube.com',
        'https://player.vimeo.com',
        'https://www.google.com',
        'https://maps.google.com',
    ];

    /**
     * Restricts the origins allowed to deliver video and audio.
     *
     * @var list<string>|string|null
     */
    public $mediaSrc = [
        'self',
        'https:', // Allow HTTPS media
        'data:', // Allow data URLs for media
        'blob:', // Allow blob URLs for media
        'https://www.youtube.com',
        'https://player.vimeo.com',
    ];

    /**
     * Allows control over Flash and other plugins.
     *
     * @var list<string>|string
     */
    public $objectSrc = 'self';

    /**
     * @var list<string>|string|null
     */
    public $manifestSrc;

    /**
     * Limits the kinds of plugins a page may invoke.
     *
     * @var list<string>|string|null
     */
    public $pluginTypes;

    /**
     * List of actions allowed.
     *
     * @var list<string>|string|null
     */
    public $sandbox;

    /**
     * Nonce tag for style
     */
    public string $styleNonceTag = '{csp-style-nonce}';

    /**
     * Nonce tag for script
     */
    public string $scriptNonceTag = '{csp-script-nonce}';

    /**
     * Replace nonce tag automatically
     */
    public bool $autoNonce = true;
}
