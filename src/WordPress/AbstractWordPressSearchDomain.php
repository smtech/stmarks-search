<?php

namespace smtech\StMarksSearch\WordPress;

use Battis\Educoder\Pest;

use smtech\StMarksSearch\AbstractSearchDomain;
use smtech\StMarksSearch\SearchResult;

/**
 * A parent object for WordPress search domains
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 */
abstract class AbstractWordPressSearchDomain extends AbstractSearchDomain
{
    /**
     * API access object
     * @var Pest
     */
    protected $api;

    /**
     * Summary information about search domain for search results
     * @var SearchSource
     */
    protected $source;

    /**
     * Construct a WordPress search domain: `$params` must contain a `url`
     * field with a valid URL to a WordPress blog
     *
     * @param mixed[] $params
     */
    public function __construct($params)
    {
        parent::__construct($params);

        $this->api = new Pest("{$params['url']}/wp-json/wp/v2");
    }

    /**
     * Hook to convert individual items returned by the WordPress API into
     * SearchResults
     *
     * @used-by AbstractWordPressSearchDomain::processResponse()
     *
     * @param array $item JSON-decoded associative array representing a
     *                    WordPress object
     * @param string $query
     * @return SearchResult
     */
    abstract protected function processItem($item, $query);

    /**
     * Process the a response from the WordPress API listing objects
     *
     * @uses AbstractWordPressSearchDomain::processItem()
     *
     * @param string $response JSON-formatted WordPress api response
     * @param string $query
     * @return SearchResult[] Unordered
     */
    protected function processResponse($response, $query)
    {
        $results = [];
        do {
            $items = json_decode($response, true);
            foreach ($items as $item) {
                $results[] = $this->processItem($item, $query);
            }

            $link = $this->api->lastHeader('Link');
            if (preg_match('@<' . $this->api->base_url . '([^>]*)?(.*)>; rel="next"@', $link, $match)) {
                parse_str($match[2], $params);
                $response = $this->api->get($match[1], $params);
            }
        } while (!empty($match));

        return $results;
    }
}
