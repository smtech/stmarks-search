<?php
/** AbstractSearchDomainFactory class */

namespace smtech\StMarksSearch;

/**
 * A parent factory class to generate an array of search domains
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 */
abstract class AbstractSearchDomainFactory extends ParameterArrayConstructor
{
    /**
     * Construct an array of search domains
     *
     * @param array $params
     * @return AbstractSearchDomain[]
     */
    public static function constructSearchDomains($params)
    {
        return [];
    }
}
