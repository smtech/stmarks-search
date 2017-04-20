<?php

namespace smtech\StMarksSearch\Canvas;

use Exception;
use smtech\CanvasPest\CanvasPest;
use smtech\StMarksSearch\RequireParameter;
use smtech\StMarksSearch\SearchEngine;

/**
 * Parent class for all Canvas search engines
 *
 * @author <SethBattis@stmarksschool.org>
 */
abstract class AbstractCanvasSearch extends SearchEngine
{
    use RequireCanvasPestParameter;

    /**
     * Construct a Canvas search engine
     *
     * @inheritdoc
     *
     * @param mixed[string] $params
     */
    public function __construct($params)
    {
        $this->requireCanvasPestParameter($params);

        $this->defaultParameter(
            $params,
            'icon',
            'https://du11hjcvx0uqb.cloudfront.net/dist/images/favicon-e10d657a73.ico'
        );
        $this->defaultParameter(
            $params,
            'url',
            preg_replace('%^(.*)/api/v\d+$%', '$1', $this->getApi()->base_url)
        );

        parent::__construct($params);
    }
}
