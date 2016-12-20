<?php

namespace Casadatos\Component\XTerm;

/**
 * Screen implements control sequences related to terminal window
 *
 */
class Screen extends XTerm
{
    const
        BUFFER_NORMAL       = 'l',
        BUFFER_ALTERNATE    = 'h';

    /**
     * Maximize terminal window to full screen
     * @param int $state
     * @return string
     */
    public function maximize($state=1) {
        return self::CSI . '9;' . $state . 't';
    }

    /**
     * Minimizes terminal window to dock / task-bar icon
     * @return string
     */
    public function iconify() {
        return self::CSI . '2;t';
    }

    /**
     * Reverses iconified terminal window to it's previous size
     * @return string
     */
    public function deiconify() {
        return self::CSI . '1;t';
    }

    /**
     * Checks whether window is iconified
     * @return bool
     */
    public function isIconified() {
        $this->holdOn();
        echo self::CSI . '11t';
        $state = trim($this->awaitResponse('t'), '[t');
        $this->holdOff();
        if ($state == 2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Resizes terminal window to full rows height and columns width
     * @param $width
     * @param $height
     * @return string
     */
    public function resizeInChars($width, $height) {
        return self::CSI . '8;' . $height . ';' . $width . 't';
    }

    /**
     * Resizes terminal window to width and height given in pixels
     * @param $width
     * @param $height
     * @return string
     */
    public function resizeInPixels($width, $height) {
        return self::CSI . '4;' . $height . ';' . $width . 't';
    }

    /**
     * Returns size of terminal window in pixels (X/Y)
     * @return array|bool
     */
    public function getSizeInPixels() {
        $this->holdOn();
        echo self::CSI . '14t';
        $state = explode(';', trim($this->awaitResponse('t'), '[t'));
        $this->holdOff();

        if ($state[0] != '4') {
            return false;
        } else {
            return array(
                'x' => $state[2],
                'y' => $state[1]);
        }
    }

    /**
     * Returns size of terminal window in columns and rows (X/Y)
     * @return array|bool
     */
    public function getSizeInChars() {
        $this->holdOn();
        echo self::CSI . '18t';
        $state = explode(';', trim($this->awaitResponse('t'), '[t'));
        $this->holdOff();

        if ($state[0] != '8') {
            return false;
        } else {
            return array(
                'x' => $state[2],
                'y' => $state[1]);
        }
    }

    /**
     * Moves terminal window on screen position defined by parameters
     * @param $x
     * @param $y
     * @return string
     */
    public function moveTo($x, $y) {
        return self::CSI . '3;' . $x . ';' . $y . 't';
    }

    /**
     * Returns terminal window position in pixels
     * @return array|bool
     */
    public function getPositionInPixels() {
        $this->holdOn();
        echo self::CSI . '13t';
        $state = explode(';', trim($this->awaitResponse('t'), '[t'));
        $this->holdOff();

        if ($state[0] != '3') {
            return false;
        } else {
            return array(
                'x' => $state[2],
                'y' => $state[1]);
        }
    }

    /**
     * Switches xterm between NORMAL and ALTERNATE buffer
     * @param $bufferType
     * @return string
     */
    public function setBuffer($bufferType) {
        return self::CSI . '?47' . $bufferType;
    }

    public function insertLines($number=1) {
        return self::CSI . $number . 'L';
    }

    public function deleteLines($number=1) {
        return self::CSI . $number . 'M';
    }

    /**
     * Fills rectangular area with certain character
     * Remarks: Not compiled into xterm by default!
     *
     * @param $char
     * @param $top
     * @param $left
     * @param $bottom
     * @param $right
     * @return string
     */
    public function fillArea($char, $top, $left, $bottom, $right) {
        return self::CSI . $char . ';' . $top . ';' . $left . ';' . $bottom . ';' . $right . '$x';
    }

    /**
     * Clears rectangular area of terminal window
     * Remarks: Not compiled into xterm by default!
     *
     * @param $top
     * @param $left
     * @param $bottom
     * @param $right
     * @return string
     */
    public function eraseArea($top, $left, $bottom, $right) {
        return self::CSI . $top . ';' . $left . ';' . $bottom . ';' . $right . ';$z';
    }

    public function setAttrChangeExtentRectangle() {
        return self::CSI . '2*x';
    }

    /**
     * Clears terminal window
     *
     * @return string
     */
    public function clear() {
        return self::CSI . '2J';
    }

    /**
     * Sets window title
     *
     * @param $title
     * @return string
     */
    public function setTitle($title) {
        return self::OSC . '0;' . $title . '' . self::BELL;
    }
}
