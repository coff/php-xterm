<?php

namespace Casadatos\Component\XTerm;

class XTerm
{
    protected $response;

    const
        /* Control characters */
        BELL    = "\007",
        BS      = "\010",
        HT      = "\011",
        LF      = "\012",
        VT      = "\013",
        FF      = "\014",
        CR      = "\015",
        ESC     = "\033",
        DEL     = "\177",
        SP      = " ",

        /* Control sequences */
        IND     = self::ESC . 'D',    // Index ( IND is 0x84)
        NEL     = self::ESC . 'E',    // Next Line ( NEL is 0x85)
        HTS     = self::ESC . 'H',    // Tab Set ( HTS is 0x88)
        RI      = self::ESC . 'M',    // Reverse Index ( RI is 0x8d)
        SS2     = self::ESC . 'N',    // Single Shift Select of G2 Character Set ( SS2 is 0x8e): affects next character only
        SS3     = self::ESC . 'O',    // Single Shift Select of G3 Character Set ( SS3 is 0x8f): affects next character only
        DCS     = self::ESC . 'P',    // Device Control String ( DCS is 0x90)
        SPA     = self::ESC . 'V',    // Start of Guarded Area ( SPA is 0x96)
        EPA     = self::ESC . 'W',    // End of Guarded Area ( EPA is 0x97)
        SOS     = self::ESC . 'X',    // Start Of String (SOS is 0x98)
        DECID   = self::ESC . 'Z',    // Return Terminal ID (DECID is 0x9a). Obsolete form of CSI c (DA).
        CSI     = self::ESC . '[',    // Control Sequence Introducer ( CSI is 0x9b)
        ST      = self::ESC . '\\',   // String Terminator ( ST is 0x9c)
        OSC     = self::ESC . ']',    // Operating System Command ( OSC is 0x9d)
        PM      = self::ESC . '^',    // Privacy Message ( PM is 0x9e)
        APC     = self::ESC . '_';    // Application Program Command ( APC is 0x9f)

    public function getResponse() {
        return $this->response;
    }

    public function bell() {
        return self::BELL;
    }

    public function reset() {
        return self::ESC . 'c';
    }

    protected function holdOn() {
        readline_callback_handler_install('', function() { }); # clears default stdin echo
    }

    protected function holdOff() {
        readline_callback_handler_remove();
    }

    protected function awaitResponse($endOfSeqChar) {
        $response = '';
        while (true) {
            $w = NULL;
            $e = NULL;
            $n = stream_select($r = array(STDIN), $w, $e, null);
            if ($n && ($data = stream_get_contents(STDIN, 1)) !== false)  {

                if (ord($data{0}) != 27) {
                    $response .= $data;
                }
                if ($data == $endOfSeqChar)  {
                    return $this->response = $response;
                }
            }
        }

        return false;
    }
}
