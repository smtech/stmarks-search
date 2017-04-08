<?php

namespace smtech\StMarksSearch\Canvas\Courses;

use smtech\CanvasPest\CanvasPest;
use smtech\StMarksSearch\SearchEngine;
use smtech\StMarksSearch\Canvas\AbstractCanvasSearch;
use smtech\StMarksSearch\Canvas\Courses\Pages\PagesSearch;

/**
 * Search a Canvas course
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 */
class CourseSearch extends AbstractCanvasSearch
{
    /**
     * Construct a CourseSearch: may have a `pages` field to indicate that
     * course pages should be searched.
     *
     * @inheritdoc
     *
     * @param CanvasPest $api
     * @param mixed[] $params
     */
    public function __construct(CanvasPest $api, $params)
    {
        parent::__construct($api, $params);

        $params['pages'] = isset($params['pages']) && filter_var($params['pages'], FILTER_VALIDATE_BOOLEAN);

        if ($params['pages']) {
            $this->addDomain(new PagesSearch($api, $params));
        }
    }
}
