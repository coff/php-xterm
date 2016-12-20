<?php

namespace Casadatos\Component\XTerm;

/**
 * Attributes class implements XTerm's SGR control sequences
 */
class Attributes extends XTerm
{
    const
        /* effects */
        EFFECT_NORMAL       = 0,
        EFFECT_BOLD         = 1,
        EFFECT_UNDERLINED   = 4,
        EFFECT_BLINK        = 5,
        EFFECT_INVERSE      = 7,
        EFFECT_INVISIBLE    = 8,

        /* foreground colors */
        FOREGROUND_RED      = 31,
        FOREGROUND_GREEN    = 32,
        FOREGROUND_YELLOW   = 33,
        FOREGROUND_BLUE     = 34,
        FOREGROUND_MAGENTA  = 35,
        FOREGROUND_CYAN     = 36,
        FOREGROUND_WHITE    = 37,
        FOREGROUND_DEFAULT  = 39,

        /* background colors */
        BACKGROUND_BLACK    = 40,
        BACKGROUND_RED      = 41,
        BACKGROUND_GREEN    = 42,
        BACKGROUND_YELLOW   = 43,
        BACKGROUND_BLUE     = 44,
        BACKGROUND_MAGENTA  = 45,
        BACKGROUND_CYAN     = 46,
        BACKGROUND_WHITE    = 47,
        BACKGROUND_DEFAULT  = 49

        ;

    /**
     * Set character attributes in 16 color palette
     * @param int $arg,...
     * @return string
     */
    public function setAttrs() {
        $args = implode(';', func_get_args());
        return self::CSI . $args . 'm';
    }

    /**
     * Set foreground color in 256 color palette
     * @param $colorValue
     * @return string
     */
    public function setFgColor($colorValue) {
        return self::CSI . '38;5;' . $colorValue . 'm';
    }

    /**
     * Set background color in 256 color palette
     * @param $colorValue
     * @return string
     */
    public function setBgColor($colorValue) {
        return self::CSI . '48;5;' . $colorValue . 'm';
    }

}
