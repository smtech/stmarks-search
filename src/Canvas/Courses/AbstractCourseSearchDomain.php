<?php

namespace smtech\StMarksSearch\Canvas\Courses;

use Exception;
use smtech\CanvasPest\CanvasPest;
use smtech\StMarksSearch\Canvas\AbstractCanvasSearchDomain;

/**
 * Parent object for Canvas course searches
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 */
abstract class AbstractCourseSearchDomain extends AbstractCanvasSearchDomain
{
    use DeriveCourseUrlFromId;

    public function __construct($params)
    {
        parent::__construct($params);

        $this->setUrl(
            $this->deriveCourseUrl(
                $this->getUrl(),
                $this->getApi()
            )
        );
    }
}
