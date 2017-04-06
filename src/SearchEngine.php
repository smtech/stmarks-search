<?php

namespace smtech\StMarksSearch;

use smtech\StMarksSearch\SearchResult;

/**
 * A collection of search domains that may be searched in aggregate
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 */
class SearchEngine extends AbstractSearchDomain
{
    /**
     * The aggregated search domains
     * @var AbstractSearchDomain[]
     */
    private $searchDomains = [];

    /**
     * Add a new search domain to this aggregate engine
     * @param AbstractSearchDomain $domain
     */
    public function addDomain(AbstractSearchDomain $domain)
    {
        /*
         * TODO ensure that domains are added only once
         */
        $this->searchDomains[] = $domain;
    }

    /**
     * Search across all search domains in the engine
     *
     * @param string $query
     * @return SearchResult[] Orded by descending relevance score
     */
    public function search($query)
    {
        /*
         * TODO add search syntax (name:, after:, before:, +/-, etc.)
         */
        $results = [];
        foreach ($this->searchDomains as $domain) {
            $results = array_merge($domain->search($query), $results);
        }
        $this->sortByRelevance($results);
        return $results;
    }

    /**
     * Generate a displayable list of the included search domains
     *
     * @param boolean $includeUrl (Optional, defaults to `true`) Should the
     *                            URLs of the search domains be included as
     *                            well as the names?
     * @param boolean $htmlFormatted (Optional, defaults to `true`) Should the
     *                               list of search domains be HTML formatted?
     * @param string $separator (Optional, defaults to `', '`)
     * @return string List of search domains aggregated by this engine (for
     *                display)
     */
    public function getDomains($includeUrl = true, $htmlFormatted = true, $separator = ', ')
    {
        $domains = [];
        foreach ($this->searchDomains as $domain) {
            if ($includeUrl) {
                if ($htmlFormatted) {
                    $domains[] = '<a href="' . $domain->getUrl() . '">' . $domain->getName() . '</a>';
                } else {
                    $domains[] = $domain->getName() . '(' . $domain->getUrl() . ')';
                }
            } else {
                $domains[] = $domain->getName();
            }
        }
        return implode($separator, $domains);
    }
}
