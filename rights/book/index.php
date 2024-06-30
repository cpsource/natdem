<?php

if ( !isset($_GET['subpage']) ) {
  get_story ( $cp_path . 'rights/book/Natural_Democracy.html' );
} else {
  $sp = $_GET['subpage'];

  switch ( $sp )
    {
    case 'intro':
      get_story ( $cp_path . 'rights/book/Introduction.html' );
      break;

    case 'ch1':
      get_story ( $cp_path . 'rights/book/Chap1f16.html' );
      break;

    case 'ch2':
      get_story ( $cp_path . 'rights/book/ch2jpj6.html' );
      break;

    case 'ch3':
      get_story ( $cp_path . 'rights/book/ch3cr17.html' );
      break;

    case 'ch4':
      get_story ( $cp_path . 'rights/book/ch4wle12.html' );
      break;

    case 'ch5':
      get_story ( $cp_path . 'rights/book/ch5test9.html' );
      break;

    case 'ch6':
      get_story ( $cp_path . 'rights/book/ch6sta20.html' );
      break;

    case 'ch7':
      get_story ( $cp_path . 'rights/book/ch7fut13.html' );
      break;

    case 'bib':
      get_story ( $cp_path . 'rights/book/bibliography.html' );
      break;

    default:
      get_story ( $cp_path . 'rights/book/Natural_Democracy.html' );
      break;
    }
}

?>
