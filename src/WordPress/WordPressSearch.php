<?php

namespace smtech\StMarksSearch\WordPress;

use smtech\StMarksSearch\SearchEngine;
use smtech\StMarksSearch\WordPress\Pages\PagesSearch;
use smtech\StMarksSearch\WordPress\Posts\PostsSearch;

/**
 * A WordPress search engine
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 */
class WordPressSearch extends SearchEngine
{
    /**
     * Construct a WordPressSearch
     *
     * `$params` may contain boolean values for `posts` and `pages` -- if
     * neither are present, `posts` will default true.
     *
     * @param mixed[] $params
     */
    public function __construct($params)
    {
        $params['posts'] = !empty($params['posts']) && filter_var($params['posts'], FILTER_VALIDATE_BOOLEAN);
        $params['pages'] = !empty($params['pages']) && filter_var($params['pages'], FILTER_VALIDATE_BOOLEAN);

        /*
         * FIXME this is really meant to be "if they didn't specify something,
         *       assume they meant posts" -- not sure that this the best way of
         *       saying that, though
         */
        if (!isset($params['posts']) && !isset($params['pages'])) {
            $params['posts'] = true;
        }

        if (!isset($params['icon'])) {
            $params['icon'] = 'https://s.w.org/favicon.ico?2';
        }

        parent::__construct($params);

        if ($params['posts']) {
            $this->addDomain(new PostsSearch($params));
        }
        if ($params['pages']) {
            $this->addDomain(new PagesSearch($params));
        }
    }
}
