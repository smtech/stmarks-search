<?php

namespace smtech\StMarksSearch\Canvas\Courses;

use Exception;
use smtech\CanvasPest\CanvasPest;

trait DeriveCourseUrlFromId
{
    /**
     * Canvas ID or SIS ID of the Canvas object
     * @var string|integer
     */
    protected $id;

    public function deriveCourseUrl($url, CanvasPest $api)
    {
        if (!preg_match('%.*/courses/\d+$%', $url)) {
            $id = $this->getId();
            if (!is_numeric($id)) {
                $course = $api->get("/courses/$id");
                if (!isset($course['id'])) {
                    throw new Exception("Unknown course `id` parameter: '$id'");
                }
                $id = $course['id'];
            }
            return "$url/courses/{$id}";
        }
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
