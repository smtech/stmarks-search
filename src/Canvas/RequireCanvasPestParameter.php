<?php

namespace smtech\StMarksSearch\Canvas;

use Exception;
use smtech\CanvasPest\CanvasPest;
use smtech\StMarksSearch\RequireParameter;

/**
 * Require and manage a CanvasPest parameter
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 */
trait RequireCanvasPestParameter
{
    use RequireParameter;

    /**
     * API access object
     * @var CanvasPest
     */
    protected $api;

    /**
     * Require and store a CanvasPest parameter
     *
     * @param mixed[string] $params
     * @param string $key (Optional, defaults to `'api'`)
     * @return void
     */
    protected function requireCanvasPestParameter($params, $key = 'api')
    {
        $this->requireParameter($params, $key, CanvasPest::class);
        $this->setApi($params[$key]);
    }

    /**
     * Update the `$api` field
     *
     * @param CanvasPest $api
     * @throws Exception If `$api` is `NULL`
     */
    protected function setApi(CanvasPest $api)
    {
        if ($api === null) {
            throw new Exception('Initialized CanvasPest object required');
        }
        $this->api = $api;
    }

    /**
     * Get the Canvas API field
     *
     * @return CanvasPest
     */
    protected function getApi()
    {
        return $this->api;
    }
}
