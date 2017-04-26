<?php
/** AbstractLibAppsSearchDomain class */

namespace smtech\StMarksSearch\LibApps;

use Exception;
use smtech\StMarksSearch\AbstractSearchDomain;

/**
 * Parent class of all LibApps search domains
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 *
 * @method LibAppsPest getApi()
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
     * @throws Exception If `site_id` parameter is not numeric LibApps ID
     */
    public function __construct($params)
    {
        $this->requireParameter($params, 'site_id');
        $this->requireParameter($params, 'key');

        $this->defaultParameter($params, 'icon', 'https://stmarksschool-ma.libapps.com/favicon.ico');

        if (!is_numeric($params['site_id'])) {
            throw new Exception('`site_id` parameter must be a valid numeric LibApps ID');
        }

        parent::__construct($params);

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
}
