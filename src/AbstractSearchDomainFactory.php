<?php

namespace smtech\StMarksSearch;

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
