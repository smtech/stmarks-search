<?php

namespace smtech\StMarksSearch\Canvas\Courses;

use smtech\StMarksSearch\Canvas\AbstractCanvasSearchDomain;

abstract class AbstractCourseSearchDomain extends AbstractCanvasSearchDomain
{
    public function __construct($params)
    {
        parent::__construct($params);

        if (!preg_match('%.*/courses/\d+$%', $this->getUrl())) {
            $id = $this->getId();
            if (!is_numeric($id)) {
                $course = $this->getApi()->get("/courses/$id");
                if (!isset($course['id'])) {
                    throw new Exception("Unknown course `id` parameter: '$id'");
                }
                $id = $course['id'];
            }
            $this->setUrl($this->getUrl() . "/courses/{$id}");
        }
    }
}
