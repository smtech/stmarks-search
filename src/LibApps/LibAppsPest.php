<?php

namespace smtech\StMarksSearch\LibApps;

use Battis\Educoder\PestJSON;

class LibAppsPest extends PestJSON
{
    private $site_id;
    private $key;

    public function __construct($site_id, $key)
    {
        parent::__construct("https://lgapi-us.libapps.com/1.1");
        $this->site_id = $site_id;
        $this->key = $key;
    }

    /**
     * Allow overriding of `http_build_query()` for idiosyncratic APIs
     * @param mixed $data
     * @return string
     **/
    protected function http_build_query($data)
    {
        $data['site_id'] = $this->site_id;
        $data['key'] = $this->key;
        return http_build_query($data);
    }
}
