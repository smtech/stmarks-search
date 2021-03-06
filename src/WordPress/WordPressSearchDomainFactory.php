<?php
/** WordPressSearchDomainFactory class */

namespace smtech\StMarksSearch\WordPress;

use smtech\StMarksSearch\AbstractSearchDomain;
use smtech\StMarksSearch\AbstractSearchDomainFactory;
use smtech\StMarksSearch\WordPress\AbstractWordPressSearchDomain;
use smtech\StMarksSearch\WordPress\Pages\PagesSearch;
use smtech\StMarksSearch\WordPress\Posts\PostsSearch;

/**
 * A factory to generate an array of all search domains relevant to a
 * particular blog entry
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 */
class WordPressSearchDomainFactory extends AbstractSearchDomainFactory
{
    const POSTS = 'posts';
    const PAGES = 'pages';

    /**
     * Construct an array of search domains relevant to a blog entry
     *
     * @param array $params
     * @return AbstractWordPressSearchDomain[]
     */
    public static function constructSearchDomains($params)
    {
        $domains = [];

        $consumedParams = [self::POSTS, self::PAGES];

        /*
         * FIXME this is really meant to be "if they didn't specify something,
         *       assume they meant posts" -- not sure that this the best way of
         *       saying that, though
         */
        if (!isset($params['posts']) && !isset($params[self::PAGES])) {
            $params[self::PAGES] = true;
        }

        $params[self::POSTS] = static::forceBooleanParameter($params, self::POSTS);
        $params[self::PAGES] = static::forceBooleanParameter($params, self::PAGES);

        if ($params[self::POSTS]) {
            $domains[] = new PostsSearch(static::consumeParameters($params, $consumedParams));
        }
        if ($params[self::PAGES]) {
            $domains[] = new PagesSearch(static::consumeParameters($params, $consumedParams));
        }

        return $domains;
    }
}
