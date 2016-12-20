<?php

namespace Casadatos\Component\XTerm;

class Mode extends XTerm
{
    const
        MODE_KEYBOARD_ACTION = 2,
        MODE_INSERT          = 4,
        MODE_SEND_RECEIVE    = 12,
        MODE_AUTO_NEWLINE    = 20;

    public function set($mode) {
        return XTerm::CSI . $mode . 'h';
    }
}
