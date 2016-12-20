<?php

namespace Casadatos\Component\XTerm;

class Scroll extends XTerm
{

    public function up($lines=1) {
        return self::CSI . $lines . 'S';
    }

    public function down($lines=1) {
        return self::CSI . $lines . 'T';
    }

    public function setRegion($top=null, $bottom=null) {
        if ($top === null) {
            return self::CSI . 'r';
        } else {
            return self::CSI . $top . ';' . $bottom . 'r';
        }

    }
}
