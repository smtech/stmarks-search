<?php

namespace smtech\StMarksSearch;

use Exception;

/**
 * Abstract class defining a search domain
 *
 * Includes a basic constructor and a reusable sorting method.
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 */
abstract class AbstractSearchDomain
{
    /**
     * Human-readable name of the search domain
     *
     * Ideally, this is loaded dynamically from the domain via API -- and any
     * dynamic result will override any preset configuration.
     * @var string
     */
    protected $name;

    /**
     * URL of the search domain's home page
     *
     * Ideally, this is loaded or constructed dynamically via API -- and any
     * dynamic result will override any preset configuration.
     * @var string
     */
    protected $url;

    /**
     * Construct a SearchDomain
     *
     * Parameters are passed to this constuctor as an associative array of values, including, at a minimum:
     *
     * ```
     * [
     *   'name' => 'A human-readable name for the domain',
     *   'url' => 'URL of the home page of the domain'
     * ]
     * ```
     *
     * Subclasses may (and will) add additional required parameters to that
     * list.
     *
     * @param mixed[] $params
     *
     * @throws Exception If `$params['url']` is not a valid URL or
     *         `$params['name']` is empty.
     */
    public function __construct($params)
    {
        assert(
            filter_var($params['url'], FILTER_VALIDATE_URL) !== false,
            new Exception("Valid url parameter required, received:" . PHP_EOL . print_r($params, true))
        );
        $this->url = $params['url'];

        assert(
            !empty($params['name']),
            new Exception('Non-empty name parameter required')
        );
        $this->name = $params['name'];
    }

    /**
     * Search within this domain
     *
     * @param string $query
     * @return SearchResult[] Ordered by descending relevance
     */
    abstract public function search($query);

    /**
     * Sort into order of descending relevance
     *
     * @param SearchResult[] $results
     * @return void
     */
    protected function sortByRelevance(&$results)
    {
        usort($results, function (SearchResult $a, SearchResult $b) {
            if ($a->getRelevance()->getScore() < $b->getRelevance()->getScore()) {
                return 1;
            } elseif ($a->getRelevance()->getScore() > $b->getRelevance()->getScore()) {
                return -1;
            } else {
                return 0;
            }
        });
    }

    /**
     * Human-readable name of the search domain
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * URL of the home page of the search domain
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
