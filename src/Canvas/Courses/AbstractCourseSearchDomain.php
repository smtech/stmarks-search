<?php
/** AbstractCourseSearchDomain class */

namespace smtech\StMarksSearch\Canvas\Courses;

use smtech\StMarksSearch\Canvas\AbstractCanvasSearchDomain;

/**
 * Parent class for all Canvas course search domains
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 */
abstract class AbstractCourseSearchDomain extends AbstractCanvasSearchDomain
{
    /**
     * Construct an course search domains
     *
     * Automagically "localizes" a Canvas instance URL to be the course's
     * unique URL (potentially using the Canvas API to resolve course ID's of
     * the format `sis_course_id:foo-bar`)
     *
     * @param array $params
     */
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
