<?php

namespace smtech\StMarksSearch;

use JsonSerializable;

/**
 * An object representing a single search result
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 */
class SearchResult extends ParameterArrayConstructor implements JsonSerializable
{
    /**
     * URL of the search result
     * @var string
     */
    protected $url;

    /**
     * Description of result's relevance
     * @var Relevance
     */
    protected $relevance;

    /**
     * Human-readable title
     * @var string
     */
    protected $title;

    /**
     * Human-readable description
     *
     * Ideally 20-100 words, may be HTML-formatted (although links should be
     * stripped out).
     * @var string
     */
    protected $description;

    /**
     * Simplified description of search domain source of the result
     * @var SearchSource
     */
    protected $source;

    /**
     * Construct a SearchResult
     *
     * Expects an associative parameter array:
     *
     * ```
     * [
     *   'url' => URL of the search result as a string,
     *   'title' => Title of the search result as a string,
     *   'relevance' => instance of `Relevance`,
     *   'source' => instance of `SearchSource`,
     *   'description' => Optional: search result descriptin as a string
     * ]
     * ```
     *
     * @param mixed[string] $params
     */
    public function __construct($params)
    {
        $this->requireParameter($params, 'url');
        $this->requireParameter($params, 'title');
        $this->requireParameter($params, 'relevance', Relevance::class);
        $this->requireParameter($params, 'source', SearchSource::class);

        $this->defaultParameter($params, 'description', '[no description available]');

        parent::__construct($params);
    }

    /**
     * Sort into order of descending relevance
     *
     * @param SearchResult[] $results
     * @return void
     */
    public static function sort(&$results)
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

    public function jsonSerialize()
    {
        return [
            'url' => $this->getUrl(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'source' => $this->getSource()->jsonSerialize(),
            'relevance' => $this->getRelevance()->jsonSerialize()
        ];
    }
}
