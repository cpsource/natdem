<?php
// find out who we are and set flag
$cpage_who = $_SERVER['SERVER_NAME'];
//echo "cpage_who = $cpage_who<br>";

if ( 0 == strcmp('natdem.com',$cpage_who) || 0 == strcmp('www.natdem.com',$cpage_who) ) {
  $cpage_remote_flag = 1;
  $cp_url = 'http://www.natdem.com';
  $cp_base = '/';
  $cp_base_url = $cp_url . $cp_base;
  $cp_host_type = 3;
  $cp_path = $_SERVER['DOCUMENT_ROOT'] . "/";
} else {
if ( 0 == strcmp('natdem.ajept.com',$cpage_who) ) {
  $cpage_remote_flag = 1;
  $cp_url = 'http://natdem.ajept.com';
  $cp_base = '/';
  $cp_base_url = $cp_url . $cp_base;
  $cp_host_type = 3;
  $cp_path = $_SERVER['DOCUMENT_ROOT'] . '/natdem/';
  //echo $_SERVER['DOCUMENT_ROOT'];
} else {
if ( 0 == strcmp('ajept.com',$cpage_who) || 0 == strcmp('ajept.com',$cpage_who) ) {
  $cpage_remote_flag = 1;
  $cp_url = 'http://ajept.com/natdem';
  $cp_base = '/';
  $cp_base_url = $cp_url . $cp_base;
  $cp_host_type = 3;
  $cp_path = $_SERVER['DOCUMENT_ROOT'] . '/natdem/';
} else {
if ( (0 == strcmp('host191.ipowerweb.com',$cpage_who)) ||
     (0 == strcmp('www.unifyinggravity.com',$cpage_who)) ) {
  $cpage_remote_flag = 1;
  $cp_url = 'http://www.natdem.com';
  $cp_base = '/';
  $cp_base_url = $cp_url . $cp_base;
  $cp_host_type = 3;
  $cp_path = '/home/unifying/public_html/natdem/';
} else {
  $cpage_remote_flag = 0;
  $cp_url = 'http://natdem';
  $cp_base = '/';
  $cp_base_url = $cp_url . $cp_base;
  $cp_host_type = 4;
  $cp_path = '/web0/natdem/';
}
}
}
}
$cp_url = '15.222.150.160';
$cp_url = "http://$cp_url";
$cp_base = '/';
$cp_base_url = $cp_url . $cp_base;
$cp_host_type = 3;
$cp_path = '/var/www/html/';
$cp_debug = 0
?>
