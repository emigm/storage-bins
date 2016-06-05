<?php

namespace StorageBins;

class JSONBin extends ArrayBin
{
    public function __construct($json, $is_camelcase = true)
    {
        $decoded_json = json_decode($json, true);

        if (is_null($decoded_json)) {
            throw new \InvalidArgumentException('$json is not a valid JSON');
        }

        parent::__construct($decoded_json, $is_camelcase);
    }
}
