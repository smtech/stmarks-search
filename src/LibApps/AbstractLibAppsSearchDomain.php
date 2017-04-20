<?php

namespace smtech\StMarksSearch\LibApps;

use Exception;
use smtech\StMarksSearch\AbstractSearchDomain;

/**
 * Parent class of all LibApps search domains
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 */
abstract class AbstractLibAppsSearchDomain extends AbstractSearchDomain
{
    /**
     * API access object
     * @var LibAppsPest
     */
    protected $api;

    /**
     * Construct a LibApps search domain: requires `site_id` and `key`
     * parameters
     *
     * @inheritdoc
     *
     * @param mixed[] $params
     */
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

    /**
     * Update the API access object
     *
     * @param string|integer $site_id
     * @param string $key
     */
    protected function setApi($site_id, $key)
    {
        $this->api = new LibAppsPest($site_id, $key);
    }

    /**
     * Access the API access object
     *
     * @return LibAppsPest
     */
    public function getApi()
    {
        return $this->api;
    }
}