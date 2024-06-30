<?php
  include( 'config.php' );
  include( 'include/never_cache.php' );

//
// To keep everything consistent on the web site
// we use this level 1 wrapper.
//
// At level 1 (this file)
//    we control head, top, left, and bottom
// At level 2 (other files)
//    we control the body and right
//
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
  <meta name="resource-type" content="document">
  <meta name="revisit-after" content="5">

  <meta name="keywords" content="Natural Democracy">
  <meta name="description" content="Natural Democracy: Homepage">
  <meta name="target" content="Homepage">

  <meta name="robots" content="ALL">
  <meta name="distribution" content="Global">
  <meta name="rating" content="General">
  <meta name="copyright" content="CalPage">
  <meta http-equiv="reply-to" content="admin@unifyinggravity.com">

<?php
$st = "<link href='" . $cp_base . "include/stylesheet_small.css' rel='stylesheet' title='master' type='text/css'>";
echo $st;
?>

  <title>Natural Democracy</title>

<script src="/include/common.js" language="JavaScript" type="text/javascript"></script>

</head>

<body onload="framebreaker()">

<!-- main table -->
<table cellpadding="2" cellspacing="2" border="0"
 style="text-align: left; height: 279px; width: 800px; margin-left: auto; margin-right: auto;">
  <tbody>

    <!-- top -->
<?php
include 'top.php';
?>
    <!-- Biline -->
<?php
include 'biline.php';
?>
    <!-- left menu and all rights row start -->
    <tr>
      <td style="vertical-align: top; width: 100px;" rowspan="1" colspan="1">
<?php
// include the left menu
include 'left_menu.php';
?>
      </td>

      <td style="vertical-align: top; width: 700px;" rowspan="1" colspan="1">
<?php
// include top story
include 'rights/index.php';
?>
      </td>
    </tr>

  </tbody>
</table>

<?php
include 'bottom.php';
?>

</body>
</html>
