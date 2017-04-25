<?php

require_once __DIR__ . '/vendor/autoload.php';

use Battis\ConfigXML;
use smtech\CanvasPest\CanvasPest;
use smtech\StMarksSearch\SearchEngine;
use smtech\StMarksSearch\Canvas\Courses\CourseSearchDomainFactory;
use smtech\StMarksSearch\WordPress\WordPressSearchDomainFactory;
use smtech\StMarksSearch\LibApps\LibGuides\LibGuidesSearchDomainFactory;

if (empty($config)) {
    $config = __DIR__ . '/config.xml';
}

$config = new ConfigXML($config);

$search = [];

if ($courses = $config->toArray('/config/canvas/course')) {
    $api = $config->newInstanceOf(CanvasPest::class, '/config/canvas/api');
    foreach ($courses as $course) {
        $course['@attributes']['api'] = $api;
        $search = array_merge($search, CourseSearchDomainFactory::constructSearchDomains($course['@attributes']));
    }
}

if ($blogs = $config->toArray('/config/wordpress/blog')) {
    foreach ($blogs as $blog) {
        $search = array_merge($search, WordPressSearchDomainFactory::constructSearchDomains($blog['@attributes']));
    }
}

if ($libguides = $config->toArray('/config/libapps/libguides')) {
    foreach ($libguides as $libguide) {
        $search = array_merge($search, LibGuidesSearchDomainFactory::constructSearchDomains($libguide['@attributes']));
    }
}
