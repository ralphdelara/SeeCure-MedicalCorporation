<?php

if (! function_exists('formatName')) {
    function formatName(string $name) {
        // Lowercase everything safely (handles accents/special characters)
        $name = mb_strtolower(trim($name), 'UTF-8');

        // Capitalize letters following spaces, hyphens, or apostrophes
        return preg_replace_callback('/\b\w|(?<=\x27)\w/u', function($matches) {
            return mb_strtoupper($matches[0], 'UTF-8');
        }, $name);
    }
}