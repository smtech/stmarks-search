<?php
/** SearchResult class */

namespace smtech\StMarksSearch;

use JsonSerializable;

/**
 * An object representing a single search result
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 *
 * @method string getUrl()
 * @method setUrl(string $url)
 * @method string getTitle()
 * @method setTitle(string $title)
 * @method string getDescription()
 * @method setDescription(string $description)
 * @method SearchSource getSource()
 * @method setSearchSource(SearchSource $source)
 * @method Relevance getRelevance()
 * @method setRelevance(Relevance $relevance)
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
     * @param array $params
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

    /**
     * Generate a hash to uniquely identify this search result
     *
     * Uniqueness is determined as a combination of the URL and its relevance
     * score (to this search)
     *
     * @return string
     */
    public function getHash()
    {
        return hash('crc32', $this->getUrl() . $this->getRelevance()->getScore());
    }

    /**
     * Return an array ready for JSON serialization
     *
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php JsonSerializable::jsonSerialize()
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'url' => $this->getUrl(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'source' => $this->getSource()->jsonSerialize(),
            'relevance' => $this->getRelevance()->jsonSerialize(),
            'hash' => $this->getHash()
        ];
    }
}
