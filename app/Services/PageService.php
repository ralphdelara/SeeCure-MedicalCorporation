<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;

class PageService
{
    /**
     * Constraints a paginator's data range structure to exactly 5 links
     * and maps it to a custom structured array format.
     */
    public function limitLinks(LengthAwarePaginator $paginator, int $windowSize = 5): array
    {
        $currentPage = $paginator->currentPage();
        $lastPage = $paginator->lastPage();

        // 1. Calculate boundaries for the sliding window
        $offset = floor(($windowSize - 1) / 2);
        $start = max(1, $currentPage - $offset);
        $end = min($lastPage, $start + ($windowSize - 1));

        if ($end - $start < ($windowSize - 1)) {
            $start = max(1, $end - ($windowSize - 1));
        }

        // 2. Get Laravel's native URL Range [page_number => url]
        $urlRange = $paginator->getUrlRange($start, $end);

        // 3. Format the array into your custom structural layout
        $formattedPages = [];
        foreach ($urlRange as $page => $url) {
            $formattedPages[] = [
                'url'    => $url,
                'label'  => (string) $page,
                'page'   => $page,
                'active' => $page === $currentPage,
            ];
        }

        return $formattedPages;
    }
}
