<?php

namespace smtech\StMarksSearch\Canvas;

use Exception;
use smtech\CanvasPest\CanvasPest;
use smtech\StMarksSearch\AbstractSearchDomain;

/**
 * Parent class for all Canvas search domains
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 */
abstract class AbstractCanvasSearchDomain extends AbstractSearchDomain
{
    use RequireCanvasPestParameter;

    /**
     * Canvas ID or SIS ID of the Canvas object
     * @var string|integer
     */
    protected $id;

    /**
     * Construct a CanvasSearchDomain from `$params`, requires `id` and `api`
     * params, will extract `url` param from `api`, if necessary.
     *
     * @inheritdoc
     *
     * @param mixed[string] $params
     */
    public function __construct($params)
    {
        $this->requireParameter($params, 'id');
        $this->requireCanvasPestParameter($params);

        if (empty($params['url'])) {
            $params['url'] = preg_replace('%^(.*)/api/v\d+$%', '$1', $this->getApi()->base_url);
        }

        parent::__construct($params);

        $this->setId($params['id']);
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

    /**
     * Get the Canvas object ID
     *
     * @return string|integer
     */
    public function getId()
    {
        return $this->id;
    }
}
