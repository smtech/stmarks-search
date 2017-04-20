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
}
