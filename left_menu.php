<!-- Begin left_menu.php -->

<?php
switch ( $cp_host_type )
{
 case 3:
  include 'sidebar.php';
  break;
 case 4:
  include 'sidebar-local.php';
  break;
}

?>

<!-- End left_menu.php -->