<?php

namespace smtech\StMarksSearch\LibApps\LibGuides;

use smtech\StMarksSearch\Relevance;
use smtech\StMarksSearch\SearchResult;
use smtech\StMarksSearch\SearchSource;
use smtech\StMarksSearch\LibApps\AbstractLibAppsSearchDomain;

/**
 * LibGuides search domain
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 */
class LibGuidesSearch extends AbstractLibAppsSearchDomain
{
    /**
     * Search for `$query` within the LibGuides
     *
     * @param string $query
     * @return SearchResult[] Ordered by descending relevance
     */
    public function search($query)
    {
        $source = new SearchSource($this);
        $results = [];
        $response = $this->getApi()->get(
            '/guides',
            [
                'search_terms' => $query,
                'search_match' => 2 // contains
            ]
        );
        if (is_array($response)) {
            foreach ($response as $result) {
                $results[] = new SearchResult([
                    'url' => $result['url'],
                    'relevance' => $this->relevance($result, $query),
                    'title' => $result['name'],
                    'description' => $result['description'],
                    'source' => $source
                ]);
            }
        }

        $this->sortByRelevance($results);
        return $results;
    }

    /**
     * Calculate relevance score for a particular search result
     *
     * @param mixed[] $guide
     * @param string $query
     * @return Relevance
     */
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
