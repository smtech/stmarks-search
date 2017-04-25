<?php

namespace smtech\StMarksSearch\LibApps\LibGuides;

use smtech\StMarksSearch\AbstractSearchDomainFactory;

class LibGuidesSearchDomainFactory extends AbstractSearchDomainFactory
{
    public static function constructSearchDomains($params)
    {
        return [new LibGuidesSearch($params)];
    }
}
