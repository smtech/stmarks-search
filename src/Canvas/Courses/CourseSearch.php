<?php

namespace smtech\StMarksSearch\Canvas\Courses;

use smtech\CanvasPest\CanvasPest;
use smtech\StMarksSearch\RequireParameter;
use smtech\StMarksSearch\SearchEngine;
use smtech\StMarksSearch\Canvas\AbstractCanvasSearch;
use smtech\StMarksSearch\Canvas\Courses\Announcements\AnnouncementsSearch;
use smtech\StMarksSearch\Canvas\Courses\Pages\PagesSearch;

/**
 * Search a Canvas course
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 */
class CourseSearch extends AbstractCanvasSearch
{
    use RequireParameter;

    /**
     * Construct a CourseSearch: may have a `pages` field to indicate that
     * course pages should be searched.
     *
     * @inheritdoc
     *
     * @param mixed[string] $params
     */
    public function __construct($params)
    {
        parent::__construct($params);

        $params['pages'] = $this->forceBooleanParameter($params, 'pages');
        $params['announcements'] = $this->forceBooleanParameter($params, 'announcements');

        if ($params['pages']) {
            $this->addDomain(new PagesSearch($params));
        }

        if ($params['announcements']) {
            $this->addDomain(new AnnouncementsSearch($params));
        }
    }
}
