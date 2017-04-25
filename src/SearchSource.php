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
    private $name;

    /**
     * URL to source home page
     * @var string
     */
    private $url;

    private $icon;

    /**
     * Construct a SearchSource from a search domain
     *
     * @param AbstractSearchDomain $domain
     */
    public function __construct(AbstractSearchDomain $domain)
    {
        $this->name = $domain->getName();
        $this->url = $domain->getUrl();
        $this->icon = $domain->getIcon();
    }

    /**
     * Human-readable name of the source search domain
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * URL of the source search domain's home page
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function getIcon()
    {
        return $this->icon;
    }
}
