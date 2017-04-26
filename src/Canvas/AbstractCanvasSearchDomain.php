<?php
/** AbstractCanvasSearchDomain class */

namespace smtech\StMarksSearch\Canvas;

use Exception;
use smtech\CanvasPest\CanvasPest;
use smtech\StMarksSearch\AbstractSearchDomain;

/**
 * Parent class for all Canvas search domains
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 *
 * @method string|integer getId()
 */
abstract class AbstractCanvasSearchDomain extends AbstractSearchDomain
{
    const ID = 'id';
    const API = 'api';

    /**
     * API access object
     * @var CanvasPest
     */
    protected $api;

    /**
     * Canvas ID of object
     * @var string|integer
     */
    protected $id;

    /**
     * Construct a CanvasSearchDomain from `$params`, requires `id` and `api`
     * params, will extract `url` param from `api`, if necessary.
     *
     * @inheritdoc
     *
     * @param array $params
     */
    public function __construct($params)
    {
        static::requireParameter($params, self::ID);
        static::requireParameter($params, self::API, CanvasPest::class);

        static::defaultParameter(
            $params,
            'icon',
            'https://du11hjcvx0uqb.cloudfront.net/dist/images/favicon-e10d657a73.ico'
        );

        $this->setApi($params[self::API]);
        if (empty($params[self::URL])) {
            $params[self::URL] = preg_replace('%^(.*)/api/v\d+$%', '$1', $this->getApi()->base_url);
        }

        parent::__construct($params);
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

    /**
     * Update the ID of the Canvas object
     *
     * @used-by AbstractCanvasSearchDomain::__construct()
     * @param string|integer $id Canvas ID or SIS ID formatted as `sis_*_id:*`
     */
    protected function setId($id)
    {
        if (!is_numeric($id) &&
            !preg_match('/^sis_[a-z]+_id:\S+$/i', $id)
        ) {
            throw new Exception('ID must be a Canvas ID or SIS ID, received:' . PHP_EOL . print_r($id, true));
        }
        $this->id = $id;
    }
}
