<?php
/** Isolated contract for curated portfolio assets; WordPress URL primitives are stubbed. */
define('ABSPATH', __DIR__);
define('WSWA_THEME_DIR', dirname(__DIR__));
define('WSWA_THEME_URI', 'https://webstudiowa.com.au/wp-content/themes/winter');
function untrailingslashit($value) { return rtrim($value, '/\\'); }
function add_query_arg($key, $value, $url) { return $url . (str_contains($url, '?') ? '&' : '?') . rawurlencode($key) . '=' . rawurlencode($value); }
require WSWA_THEME_DIR . '/inc/helpers.php';
$previews = [];
foreach (wswa_default_clients() as $default) {
    $stored = $default;
    $stored['name'] = 'Stored title: ' . $default['name'];
    $stored['summary'] = 'Existing database description';
    $stored['type'] = 'Existing database category';
    $stored['image'] = 'https://s.wordpress.com/mshots/old-image';
    $preview = wswa_portfolio_preview($stored);
    foreach (['name', 'summary', 'type', 'url', 'featured'] as $field) {
        if ($preview[$field] !== $stored[$field]) { throw new RuntimeException('Stored client content changed: ' . $field); }
    }
    if (! str_starts_with($preview['image'], $default['image'] . '?ver=') || ! $preview['uses_snapshot']) {
        throw new RuntimeException('Known client did not select its local versioned preview');
    }
    $identity = wswa_client_identity_key($default);
    $previews[$identity] = ['image' => $preview['image'], 'alt' => $preview['image_alt']];
}
$unknown = ['name' => 'Future client', 'url' => 'https://example.org/', 'image' => 'https://example.org/approved.webp'];
if (wswa_portfolio_preview($unknown) !== $unknown) { throw new RuntimeException('Unknown client image overridden'); }
echo json_encode($previews, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
