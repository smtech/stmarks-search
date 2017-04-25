<?php

namespace smtech\StMarksSearch;

/**
 * An object representing a simplified description of a search result's source
 * search domain
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 */
class SearchSource extends ParameterArrayConstructor
{
    /**
     * Human-readable name
     * @var string
     */
    protected $name;

    /**
     * URL to source home page
     * @var string
     */
    protected $url;

    protected $icon;

    /**
     * Construct a SearchSource from a search domain
     *
     * @param AbstractSearchDomain $domain
     */
    public function __construct(AbstractSearchDomain $domain)
    {
        parent::__construct([
            'name' => $domain->getName(),
            'url' => $domain->getUrl(),
            'icon' => $domain->getIcon()
        ]);
    }
}
