<?php

namespace App\Actions\Search;

class ParseSearchQueryAction
{
    /**
     * Create the action.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Parse the search query into filters.
     *
     * @param string|null $query
     * @return array
     */
    public function execute(?string $query) : array
    {
        if (!$query) {
            return [];
        }

        $filters = [];
        $pattern = '/(\w+)="([^"]+)"|(\w+)=([^ ]+)/'; // Match key="value" OR key=value
        preg_match_all($pattern, $query, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $key = $match[3] ?? $match[0];
            $value = $match[4] ?? $match[2];
            $filters[$key] = $value;
        }

        return $filters;
    }
}
