<?php

namespace Casadatos\Component\XTerm;

class Cursor extends XTerm
{
    public function up($rows=1) {
        return self::CSI . $rows . 'A';
    }

    public function down($rows=1) {
        return self::CSI . $rows . 'B';
    }

    public function forward($columns=1) {
        return self::CSI . $columns . 'C';
    }

    public function backward($columns=1) {
        return self::CSI . $columns . 'D';
    }

    public function setPosition($column, $row) {
        return self::CSI . $row . ';' . $column . 'H';
    }

    public function getPosition() {
        $this->holdOn();
        echo self::CSI . '6n';
        $response = explode(";", trim($this->awaitResponse('R'), '[R'));
        $this->holdOff();

        return array (
            'x' => $response[1],
            'y' => $response[0]);
    }

    public function column($number=1) {
        return self::CSI . $number . 'G';
    }

    public function row($number=1) {
        return self::CSI . $number . 'd';
    }

    public function savePosition() {
        return self::ESC . '7';
    }

    public function restorePosition() {
        return self::ESC . '8';
    }

    public function insertBlanks($number=1) {
        return self::CSI . $number . '@';
    }

    public function deleteCharacters($number=1) {
        return self::CSI . $number . 'P';
    }

    public function eraseCharacters($number=1) {
        return self::CSI . $number . 'X';
    }
}
