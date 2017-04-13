<?php

namespace smtech\StMarksSearch\WordPress;

use Battis\Educoder\PestJSON;

class WordPressPest extends PestJSON
{
    public function __construct($url)
    {
        if (!preg_match('%.*/wp-json/wp/v\d+$%', $url)) {
            $url = "$url/wp-json/wp/v2";
        }
        parent::__construct($url);
    }
}
