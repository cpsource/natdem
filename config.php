<?php
// Find out who we are and set flag
$cpage_who = $_SERVER['SERVER_NAME'];
$cp_debug = false;

// Check if $cp_debug is true to enable debugging
if (isset($cp_debug) && $cp_debug) {
    echo "<pre>";
    echo "cpage_who = $cpage_who<br>";
}

if (strcmp('natdem.net', $cpage_who) === 0 || strcmp('www.natdem.net', $cpage_who) === 0) {
    $cpage_remote_flag = 1;
    $cp_url = 'https://www.natdem.net';
    $cp_base = '/';
    $cp_base_url = $cp_url . $cp_base;
    $cp_host_type = 3;
    $cp_path = $_SERVER['DOCUMENT_ROOT'] . "/";
} elseif (strcmp('natdem.ajept.com', $cpage_who) === 0) {
    $cpage_remote_flag = 1;
    $cp_url = 'https://natdem.ajept.com';
    $cp_base = '/';
    $cp_base_url = $cp_url . $cp_base;
    $cp_host_type = 3;
    $cp_path = $_SERVER['DOCUMENT_ROOT'] . '/natdem/';
} elseif (strcmp('ajept.com', $cpage_who) === 0 || strcmp('ajept.com', $cpage_who) === 0) {
    $cpage_remote_flag = 1;
    $cp_url = 'https://ajept.com/natdem';
    $cp_base = '/';
    $cp_base_url = $cp_url . $cp_base;
    $cp_host_type = 3;
    $cp_path = $_SERVER['DOCUMENT_ROOT'] . '/natdem/';
} elseif (strcmp('host191.ipowerweb.com', $cpage_who) === 0 || strcmp('www.unifyinggravity.com', $cpage_who) === 0) {
    $cpage_remote_flag = 1;
    $cp_url = 'https://www.natdem.net';
    $cp_base = '/';
    $cp_base_url = $cp_url . $cp_base;
    $cp_host_type = 3;
    $cp_path = '/home/unifying/public_html/natdem/';
} else {
    $cpage_remote_flag = 0;
    $cp_url = 'https://natdem.org';
    $cp_base = '/';
    $cp_base_url = $cp_url . $cp_base;
    $cp_host_type = 4;
    $cp_path = getcwd() . '/';
}

$cp_url = '3.215.108.124';
$cp_user = 'admin';
$cp_pass = 'password123';
$cp_getcwd = getcwd();

if (isset($cp_debug) && $cp_debug) {
    echo "cpage_remote_flag = $cpage_remote_flag<br>";
    echo "cp_url = $cp_url<br>";
    echo "cp_base = $cp_base<br>";
    echo "cp_base_url = $cp_base_url<br>";
    echo "cp_host_type = $cp_host_type<br>";
    echo "cp_path = $cp_path<br>";
    echo "cp_user = $cp_user<br>";
    echo "cp_pass = $cp_pass<br>";
    echo "cp_getcwd = $cp_getcwd<br>";
    echo "</pre>";
}

?>

