<?php

namespace Gy\CoreBundle\Common;

class Tool {

    public static function genGuid() {
        $vector = rand(0, 100 * 100 * 100);
        $result = md5($vector . microtime());
        return $result;
    }

}
