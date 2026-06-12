<?php
/**
 * GitHub update integration for Winter.
 *
 * @package Winter
 */

if (! defined('ABSPATH')) {
    exit;
}

const WSWA_GITHUB_OWNER = 'asankalk';
const WSWA_GITHUB_REPO = 'webstudiowa-Winter';
const WSWA_GITHUB_API = 'https://api.github.com/repos/' . WSWA_GITHUB_OWNER . '/' . WSWA_GITHUB_REPO;

function wswa_github_request(string $url)
{
    $headers = [
        'Accept' => 'application/vnd.github+json',
        'User-Agent' => 'Winter WordPress Theme',
    ];

    $token = apply_filters('winter_github_token', defined('WINTER_GITHUB_TOKEN') ? WINTER_GITHUB_TOKEN : '');
    if ($token) {
        $headers['Authorization'] = 'Bearer ' . $token;
    }

    $response = wp_remote_get($url, [
        'headers' => $headers,
        'timeout' => 12,
    ]);

    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) >= 400) {
        return null;
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);
    return is_array($data) ? $data : null;
}

function wswa_latest_github_release(): ?array
{
    $cached = get_site_transient('winter_github_release');
    if (is_array($cached)) {
        return $cached;
    }

    $release = wswa_github_request(WSWA_GITHUB_API . '/releases/latest');

    if (! $release || empty($release['tag_name'])) {
        $tags = wswa_github_request(WSWA_GITHUB_API . '/tags');
        if (! empty($tags[0]['name'])) {
            $version = wswa_normalize_version((string) $tags[0]['name']);
            $release = [
                'tag_name' => $tags[0]['name'],
                'name' => $tags[0]['name'],
                'body' => wswa_github_changelog_for_version($version, (string) $tags[0]['name']),
                'html_url' => 'https://github.com/' . WSWA_GITHUB_OWNER . '/' . WSWA_GITHUB_REPO . '/releases',
                'zipball_url' => $tags[0]['zipball_url'] ?? '',
            ];
        }
    }

    if (! $release || empty($release['tag_name'])) {
        return null;
    }

    set_site_transient('winter_github_release', $release, 6 * HOUR_IN_SECONDS);
    return $release;
}

function wswa_normalize_version(string $version): string
{
    return ltrim(trim($version), "vV \t\n\r\0\x0B");
}

function wswa_github_changelog_for_version(string $version, string $ref): string
{
    $url = 'https://raw.githubusercontent.com/' . WSWA_GITHUB_OWNER . '/' . WSWA_GITHUB_REPO . '/' . rawurlencode($ref) . '/CHANGELOG.md';
    $response = wp_remote_get($url, [
        'headers' => ['User-Agent' => 'Winter WordPress Theme'],
        'timeout' => 12,
    ]);

    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) >= 400) {
        return 'See CHANGELOG.md on GitHub for release notes.';
    }

    $body = (string) wp_remote_retrieve_body($response);
    $pattern = '/^##\s+\[?' . preg_quote($version, '/') . '\]?.*?\R(?P<section>.*?)(?=^##\s+|\z)/ms';
    if (preg_match($pattern, $body, $matches) && ! empty(trim($matches['section']))) {
        return trim($matches['section']);
    }

    return 'See CHANGELOG.md on GitHub for release notes.';
}

add_filter('pre_set_site_transient_update_themes', function ($transient) {
    if (empty($transient->checked) || ! isset($transient->checked[get_stylesheet()])) {
        return $transient;
    }

    $release = wswa_latest_github_release();
    if (! $release) {
        return $transient;
    }

    $current_version = wswa_normalize_version((string) $transient->checked[get_stylesheet()]);
    $remote_version = wswa_normalize_version((string) $release['tag_name']);

    if (! version_compare($remote_version, $current_version, '>')) {
        return $transient;
    }

    $transient->response[get_stylesheet()] = [
        'theme' => get_stylesheet(),
        'new_version' => $remote_version,
        'url' => $release['html_url'] ?? 'https://github.com/' . WSWA_GITHUB_OWNER . '/' . WSWA_GITHUB_REPO,
        'package' => $release['zipball_url'] ?? 'https://github.com/' . WSWA_GITHUB_OWNER . '/' . WSWA_GITHUB_REPO . '/archive/refs/tags/' . rawurlencode((string) $release['tag_name']) . '.zip',
        'requires' => '6.5',
        'requires_php' => '8.0',
    ];

    return $transient;
});

add_filter('themes_api', function ($result, string $action, object $args) {
    if ($action !== 'theme_information' || empty($args->slug) || $args->slug !== get_stylesheet()) {
        return $result;
    }

    $release = wswa_latest_github_release();
    $theme = wp_get_theme();
    $notes = $release['body'] ?? 'Release notes are published on GitHub.';

    return (object) [
        'name' => $theme->get('Name'),
        'slug' => get_stylesheet(),
        'version' => $release ? wswa_normalize_version((string) $release['tag_name']) : $theme->get('Version'),
        'author' => $theme->get('Author'),
        'homepage' => 'https://github.com/' . WSWA_GITHUB_OWNER . '/' . WSWA_GITHUB_REPO,
        'requires' => '6.5',
        'requires_php' => '8.0',
        'sections' => [
            'description' => $theme->get('Description'),
            'changelog' => wp_kses_post(wpautop($notes)),
        ],
    ];
}, 10, 3);

add_action('upgrader_process_complete', function ($upgrader, array $hook_extra) {
    if (($hook_extra['type'] ?? '') === 'theme') {
        delete_site_transient('winter_github_release');
    }
}, 10, 2);
