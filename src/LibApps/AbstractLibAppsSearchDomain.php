<?php

namespace smtech\StMarksSearch\LibApps;

use Exception;
use smtech\StMarksSearch\AbstractSearchDomain;

abstract class AbstractLibAppsSearchDomain extends AbstractSearchDomain
{
    /**
     * API access object
     * @var LibGuidesPest
     */
    protected $api;

    public function __construct($params)
    {
        if (!isset($params['icon'])) {
            $params['icon'] = 'https://stmarksschool-ma.libapps.com/favicon.ico';
        }

        parent::__construct($params);

        assert(
            !empty($params['site_id']) && is_numeric($params['site_id']),
            new Exception('`site_id` parameter must be a valid numeric LibApps ID')
        );
        assert(
            !empty($params['key']),
            new Exception('`key` parameter must not be empty')
        );

        $this->setApi($params['site_id'], $params['key']);
    }

    protected function setApi($siteId, $key)
    {
        $this->api = new LibAppsPest($siteId, $key);
    }

    public function getApi()
    {
        return $this->api;
    }
}
