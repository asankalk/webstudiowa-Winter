<?php
/**
 * Resource article data accessors.
 *
 * The starter copy is retained from the existing resource helper dataset and
 * normalised here for page templates and the one-time page creator.
 *
 * @package WebStudioWA
 */

if (! defined('ABSPATH')) {
    exit;
}

function wswa_get_resource_articles(): array
{
    $articles = wswa_resource_articles();

    foreach ($articles as $slug => $article) {
        $points = $article['points'] ?? [];

        $articles[$slug]['slug'] = $slug;
        $articles[$slug]['excerpt'] = $article['summary'] ?? '';
        $articles[$slug]['sections'] = [
            [
                'heading' => __('What to consider', 'winter'),
                'paragraphs' => array_slice($points, 0, 2),
            ],
            [
                'heading' => __('A practical next step', 'winter'),
                'paragraphs' => array_slice($points, 2),
            ],
        ];
        $articles[$slug]['related_slugs'] = array_values(array_filter(
            array_keys($articles),
            static fn (string $related_slug): bool => $related_slug !== $slug && $articles[$related_slug]['category'] === $article['category']
        ));
    }

    return $articles;
}

function wswa_get_resource_article_by_slug(string $slug): ?array
{
    $articles = wswa_get_resource_articles();
    return $articles[$slug] ?? null;
}
