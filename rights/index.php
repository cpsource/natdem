<!-- Begin rights/index.php -->

<?php
  // rights/index.php

  //
  // get the body of an .html file
  // and display it
  //
function get_story ( $fil )
{
/*  echo "<center><h1>Getting Story $fil </h1></center><br><hr>"; */

  $flag = 0;
  $handle = fopen ( $fil, "r");
  if ( !$handle ) {
    echo "<center><h1>No Story $fil </h1></center><br>";
  } else {

    // body
    while (!feof ($handle)) {
      $buffer = fgets($handle);
      if ( 0 == $flag ) {
	  // find <body>
	  if ( 0 == strncasecmp($buffer,'<body',5) ) {
		  $flag = 1;
	  }
	  continue;
      }
      if ( 0 == strncasecmp($buffer,'</body>',7) ) {
	  break;
      }
      // display
      echo $buffer;
    }
    fclose ($handle);
  }
}

//
// This block of code allows us to generate a fancy smancy
// backward link for the 'rights' block. It's either
// 'Home >' or 'Home > Subpage >'
// depending on how deep the user wants to go.
//
if ( !isset($_GET['page'] ) ) {
  $pa = 'homepage';
} else {
  $pa = $_GET['page'];
}

/* echo "<a>at cp1, page = $pa</a></br>"; */

if ( isset($_GET['subpage']) ) {
  $tmp = ucfirst($pa);
  $goh = "
     <div class='breadcrumb'>
     <a href='" . $cp_base_url . "'>Home </a>&gt;
     <a href='" . $cp_base_url . "?page=$pa'>$tmp </a>&gt;
     </div>";
} else {
  $goh = "
     <div class='breadcrumb'>
     <a href='" . $cp_base_url . "'>Home </a>&gt;
     </div>";
}
// allow user to 'gohome'
echo $goh;
// allow user to 'gohome'
//echo "<a class='breadcrumb' href='" . $cp_base_url . "'>Home ></a>";

//
// onward with the main rights table
//
$tc = '<hr>
       <table cellpadding="2" cellspacing="2" border="0" style="text-align: left; width: 700px;">
       <tbody>
       <tr><td>';
$bc = '</tr></td>
       </tbody>
       </table>';

// start the main right table
echo $tc;

/* echo "<a>at cp2, page = $pa</a></br>"; */

// goto whatever page is indicated
switch ( $pa )
{
 case 'homepage':
/*      echo "<a>at cp3, page = $pa</a></br>"; */
      include 'homepage/index.php';
      break;

 case 'end9':
      include 'end9/index.php';
      break;

 case 'bombs':
      include 'bombs/index.php';
      break;

 case 'family-pictures':
      include 'family-pictures/index.php';
      break;

 case 'obituary':
      include 'obituary/index.php';
      break;
      
 case 'pressroom':
   include 'pressroom/index.php';
   break;

 case 'book':
   include 'book/index.php';
   break;

 case 'author':
   include 'author/index.php';
   break;

 case 'udohr':
   include 'udohr/index.php';
   break;

 case 'greatgoals':
   include 'greatgoals/index.php';
   break;

   /*
 case 'get_local':
   include 'get_local/index.php';
   break;

 case 'contribute':
   include 'contribute/index.php';
   break;

 case 'volunteer':
   include 'volunteer/index.php';
   break;

 case 'about':
   include 'about/index.php';
   break;

 case 'links':
   include 'links/links.php';
   break;

 case 'legal':
   include 'legal-info/index.php';
   break;

 case 'FEC_Reports':
   include 'legal-info/FEC_Reports/index.php';
   break;

 case 'Privacy_Policy':
   echo "<hr>";
   get_story ( $cp_path . '/rights/legal-info/Privacy_Policy.html' );
   break;

 case 'Fair_Use':
   echo "<hr>";
   get_story ( $cp_path . '/rights/legal-info/Fair_Use_Notice.html' );
   break;

 case 'contact':
   include 'contact/index.php';
   break;

 case 'issues':
   include 'issues/index.php';
   break;
 
 case 'tst':
   include 'tst/index.php';
   break;

 case 'events':
   include 'events/index.php';
   break;

 case 'gotv':
   include 'gotv/index.php';
   break;
   */

 default:
   echo "Page $pa not found<br>";
   break;
}

/* <hr> */
/*get_story ( 'rights/homepage/Web_Project_Outline.html' ); */

// end the main right table
echo $bc;

?>

<!-- End rights/index.php -->
