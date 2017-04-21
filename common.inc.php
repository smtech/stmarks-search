<?php

require_once __DIR__ . '/vendor/autoload.php';

use Battis\ConfigXML;
use smtech\CanvasPest\CanvasPest;
use smtech\StMarksSearch\SearchEngine;
use smtech\StMarksSearch\Canvas\Courses\CourseSearch;
use smtech\StMarksSearch\WordPress\WordPressSearch;
use smtech\StMarksSearch\LibApps\LibGuides\LibGuidesSearch;

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
                $course['@attributes']['api'] = $api;
                $search->addDomain(new CourseSearch($course['@attributes']));
            }
        } else {
            $canvas['course']['@attributes']['api'] = $api;
            $search->addDomain(new CourseSearch($canvas['course']['@attributes']));
        }
    }
}

if ($blogs = $config->toArray('/config/wordpress/blog')) {
    foreach ($blogs as $blog) {
        $search->addDomain(new WordPressSearch($blog['@attributes']));
    }
}

if ($libguides = $config->toArray('/config/libapps/libguides')) {
    foreach ($libguides as $libguide) {
        $search->addDomain(new LibGuidesSearch($libguide['@attributes']));
    }
}
