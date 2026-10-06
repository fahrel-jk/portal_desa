<?php
/**
 * One-time script to clean ═══ separator comments from Blade files.
 * Handles multiline patterns like:
 *   {{-- ═══════════
 *        TITLE TEXT
 *        ═══════════ --}}
 */

$viewsDir = __DIR__ . '/resources/views';

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($viewsDir)
);

$cleaned = 0;

foreach ($iterator as $file) {
    if ($file->getExtension() !== 'php') continue;

    $content = file_get_contents($file->getPathname());
    $original = $content;

    // Pattern: multiline 3-line blocks
    $content = preg_replace(
        '/(\h*)\{\{--\s*═+\s*\r?\n\s*(.*?)\s*\r?\n\s*═+\s*--\}\}/',
        '$1{{-- $2 --}}',
        $content
    );

    // Pattern: single-line with ═ on both sides
    $content = preg_replace(
        '/\{\{--\s*═+\s*(.*?)\s*═+\s*--\}\}/',
        '{{-- $1 --}}',
        $content
    );

    if ($content !== $original) {
        file_put_contents($file->getPathname(), $content);
        echo "Cleaned: " . $file->getPathname() . "\n";
        $cleaned++;
    }
}

echo "\nDone. Cleaned $cleaned file(s).\n";
