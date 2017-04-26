<?php
/** SearchSource class */

namespace smtech\StMarksSearch;

use JsonSerializable;

/**
 * An object representing a simplified description of a search result's source
 * search domain
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 *
 * @method setName(string $name)
 * @method string getName()
 * @method setUrl(string $url)
 * @method string getUrl()
 * @method setIcon(string $iconUrl)
 * @method string getIcon()
 */
class SearchSource extends ParameterArrayConstructor implements JsonSerializable
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

    /**
     * URL to source icon image
     * @var string
     */
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
            'name' => $this->getName(),
            'url' => $this->getUrl(),
            'icon' => $this->getIcon()
        ];
    }
}
