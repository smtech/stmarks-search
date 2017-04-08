<?php

require_once __DIR__ . '/vendor/autoload.php';

use Battis\ConfigXML;
use smtech\CanvasPest\CanvasPest;
use smtech\StMarksSearch\SearchEngine;
use smtech\StMarksSearch\Canvas\Courses\CourseSearch;
use smtech\StMarksSearch\WordPress\WordPressSearch;

if (empty($config)) {
    $config = __DIR__ . '/config.xml';
}

$config = new ConfigXML($config);

$search = new SearchEngine($config->toArray('/config/engine')[0]);

if ($canvases = $config->toArray('/config/canvas')) {
    foreach ($canvases as $canvas) {
        $api = new CanvasPest($canvas['api']['url'], $canvas['api']['token']);
        if (count($canvas['course']) > 1) {
            foreach ($canvas['course'] as $course) {
                $search->addDomain(new CourseSearch($api, $course['@attributes']));
            }
        } else {
            $search->addDomain(new CourseSearch($api, $canvas['course']['@attributes']));
        }
    }
}

if ($blogs = $config->toArray('/config/wordpress/blog')) {
    foreach ($blogs as $blog) {
        $search->addDomain(new WordPressSearch($blog['@attributes']));
    }
}
