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
     * @param string|null $query A search query string in the format key=value.
     * @return array<string, string> An associative array with keys like "user" and "status".
     * @example ['user' => 'admin', 'status' => 'sent']
     */
    public function execute(?string $query) : array
    {
        if (!$query) {
            return [];
        }

        $filters = [];

        // match key=value
        $pattern = '/(\w+)="([^"]+)"|(\w+)=([^ ]+)/';
        preg_match_all($pattern, $query, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $key = $match[3] ?? $match[0];
            $value = $match[4] ?? $match[2];
            $filters[$key] = $value;
        }

        return $filters;
    }
}
