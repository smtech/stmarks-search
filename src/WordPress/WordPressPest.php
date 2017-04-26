<?php
/** WordPressPest class */

namespace smtech\StMarksSearch\WordPress;

use Battis\Educoder\PestJSON;

/**
 * WordPress API wrapper class
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 */
class WordPressPest extends PestJSON
{
    /**
     * Construct a WordPress API handler
     *
     * @param string $url URL to a WordPress blog or a WordPress API instance
     */
    public function __construct($url)
    {
        if (!preg_match('%.*/wp-json/wp/v\d+$%', $url)) {
            $url = "$url/wp-json/wp/v2";
        }
        parent::__construct($url);
    }
}
