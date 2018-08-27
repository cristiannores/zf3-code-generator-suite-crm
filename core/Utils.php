<?php

function create_guid() {
    $microTime = microtime();
    list($a_dec, $a_sec) = explode(' ', $microTime);

    $dec_hex = dechex($a_dec * 1000000);
    $sec_hex = dechex($a_sec);

    ensure_length($dec_hex, 5);
    ensure_length($sec_hex, 6);

    $guid = '';
    $guid .= $dec_hex;
    $guid .= create_guid_section(3);
    $guid .= '-';
    $guid .= create_guid_section(4);
    $guid .= '-';
    $guid .= create_guid_section(4);
    $guid .= '-';
    $guid .= create_guid_section(4);
    $guid .= '-';
    $guid .= $sec_hex;
    $guid .= create_guid_section(6);

    return $guid;
}

function create_guid_section($characters) {
    $return = '';
    for ($i = 0; $i < $characters; ++$i) {
        $return .= dechex(mt_rand(0, 15));
    }

    return $return;
}

function ensure_length(&$string, $length) {
    $strlen = strlen($string);
    if ($strlen < $length) {
        $string = str_pad($string, $length, '0');
    } elseif ($strlen > $length) {
        $string = substr($string, 0, $length);
    }
}

function changeDateTimeZone($date) {

    $nowUtc = (new \DateTime($date, new \DateTimeZone('UTC')));
    $nowUtc->setTimezone(new \DateTimeZone('America/Santiago'));
    return $nowUtc->format('Y-m-d h:i:s');
}
