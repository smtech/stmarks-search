<?php

namespace smtech\StMarksSearch\WordPress\Posts;

use smtech\StMarksSearch\Relevance;
use smtech\StMarksSearch\SearchResult;
use smtech\StMarksSearch\SearchSource;
use smtech\StMarksSearch\WordPress\AbstractWordPressSearchDomain;

/**
 * Search a WordPress blog's posts
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 */
class PostsSearch extends AbstractWordPressSearchDomain
{
    /**
     * Search the posts for a particular `$query`
     *
     * Dependent on the WordPress post-listing search engine
     *
     * @param string $query
     * @return SearchResult[] Ordered by descending relevance
     */
    public function search($query)
    {
        $this->source = new SearchSource($this);
        $results = $this->processResponse(
            $this->getApi()->get('/posts', ['search' => $query]),
            $query
        );

        $this->sortByRelevance($results);
        return $results;
    }

    /**
     * Convert each post into a SearchResult
     *
     * @param mixed[] $post
     * @param string $query
     * @return SearchResult
     */
    protected function processItem($post, $query)
    {
        return new SearchResult(
            $post['link'],
            $this->relevance($post, $query),
            $post['title']['rendered'],
            preg_replace('@<p class="continue-reading-button">.*</p>@', '', $post['excerpt']['rendered']),
            $this->source
        );
    }

    /**
     * Calculate the relevance of each post the `$query`
     *
     * @param mixed[] $post
     * @param string $query
     * @return Relevance
     */
    protected function relevance($post, $query)
    {
        $relevance = new Relevance();

        $relevance->add(Relevance::stringProportion($post['title']['rendered'], $query), 'title match');

        if (($count = substr_count(strtolower($post['content']['rendered']), strtolower($query))) > 0) {
            $relevance->add($count * 0.01, "$count occurrences in body");
        }

        return $relevance;
    }
}
