<?php

namespace Casadatos\Component\XTerm;

class Device extends XTerm
{
    public function requestAttrs() {
        return XTerm::CSI . 'c';
    }
}
