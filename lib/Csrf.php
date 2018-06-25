<?php

class Csrf {
    public static function generate()
    {
        return binx2hex(random_bytes(30));
    }

    public static function as_input()
    {
        return '<input type="hidden" id="csrf" name="csrf" value="' . $_SESSION['csrf'] . '" />';
    }
}