<?php

namespace smtech\StMarksSearch\LibApps\LibGuides;

use Exception;
use smtech\StMarksSearch\Relevance;
use smtech\StMarksSearch\SearchResult;
use smtech\StMarksSearch\SearchSource;
use smtech\StMarksSearch\LibApps\AbstractLibAppsSearchDomain;

class LibGuidesSearch extends AbstractLibAppsSearchDomain
{
    public function search($query)
    {
        $source = new SearchSource($this);
        $results = [];
        foreach ($this->getApi()->get(
            '/guides',
            [
                'search_terms' => $query,
                'search_match' => 2
            ]
        ) as $result) {
            $results[] = new SearchResult(
                $result['url'],
                $this->relevance($result, $query),
                $result['name'],
                $result['description'],
                $source
            );
        }

        $this->sortByRelevance($results);
        return $results;
    }

    protected function relevance($guide, $query)
    {
        $relevance = new Relevance();

        $relevance->add(Relevance::stringProportion($guide['name'], $query), 'title match');

        if (($count = substr_count(strtolower($guide['description']), strtolower($query))) > 0) {
            $relevance->add($count * 0.01, "$count occurrences in description");
        }

        return $relevance;
    }
}
