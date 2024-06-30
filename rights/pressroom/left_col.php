<?php
// left_col.php

$summary = '';

// get $summary
function get_issue_summary ( $fil )
{
  global $summary;

  //echo 'get_issue_summary: entry, fil = '.$fil.'<br>';

  $summary = '';
  $fil = getcwd().'/rights/pressroom/usr/'.$fil.'.html';

  $flag = 0;
  $handle = fopen ( $fil, "r");
  if ( !$handle ) {
    $summary = '<center><h1>No Issue</h1></center><br>';
  } else {
    // body
    while (!feof ($handle)) {
      $buffer = fgets($handle);
      if ( 0 == $flag ) {
	// get to summary header, one pound
	if ( 0 == strncasecmp($buffer,'#',1) ) {
	  $flag = 1;
	}
	continue;
      }
      // are we at the end of the summary ???, two pounds
      if ( 0 == strncasecmp($buffer,'##',2) ) {
	break;
      }
      // save up
      $summary = $summary . $buffer;
    }
    fclose ($handle);
  }
}

// get $summary
function get_issue_body ( $fil )
{
  global $summary;

  $summary = '';
  $fil = getcwd().'/rights/pressroom/usr/'.$fil.'.html';

  $flag = 0;
  $handle = fopen ( $fil, "r");
  if ( !$handle ) {
    $summary = '<center><h1>No Issue</h1></center><br>';
  } else {
    // body
    while (!feof ($handle)) {
      $buffer = fgets($handle);
      if ( 0 == $flag ) {
	// get to summary header, one pound
	if ( 0 == strncasecmp($buffer,'<body>',6) ) {
	  $flag = 1;
	}
	continue;
      }
      // are we at the end of the summary ???, two pounds
      if ( 0 == strncasecmp($buffer,'</body>',7) ) {
	break;
      }
      // save up
      $summary = $summary . $buffer;
    }
    fclose ($handle);
  }
}


// an issue looks like this
$is = "<!--- ISSUE %NO% --->
<img height='2' alt='' src='/images/pixel.gif' width='1' border='0'><br>
<table cellspacing='0' cellpadding='0' width='400' border='0'>
<tbody>
  <tr>
    <td>
      <p><span class='sectionheader'><br><a href='?page=pressroom&subpage=%SUBPAGE%'>%TITLE%</a></span></p>
    </td>
  </tr>
  <tr>
    <td><img height='12' alt='' src='/images/pixel.gif' width='1' border='0'>
    </td>
  </tr>
  <tr>
    <td class='mediumtext' valign='top'>
      <p>%BODY%<p>
    </td>
  </tr>
  <tr>
    <td class='smalltext' align='right' height='20'>
      <img height='7' alt='' src='/images/arrow.gif' width='9' border='0'>
      <a href='?page=pressroom&subpage=%SUBPAGE%'>View Details</a>
    </td>
  </tr>
  <tr>
    <td align='right'><img height='1' alt='' src='/images/divider_line1.gif' width='400' border='0'>
    </td>
  </tr>
</tbody>
</table>";

// show an issue in our prescribed format
function show_issue ( $num,        // number of the issue 1 2 3 etc
		      $subpage,    // where off issues we find it
		      $title,      // the title of the issue
		      $body )      // brief description of the issue
{
  global $is;

  $tmp = str_replace ( '%NO%', $num, $is );
  $tmp = str_replace ( '%SUBPAGE%' , $subpage, $tmp );
  $tmp = str_replace ( '%TITLE%', $title, $tmp );
  $tmp = str_replace ( '%BODY%', $body, $tmp );

  echo $tmp;
}

?>

<table cellspacing='0' cellpadding='0' width='400' border='0'>
<tbody>
    <tr>
        <!-- move down -->
	<td valign="top"><img src="/images/pixel.gif" width="1" height="15" alt="" border="0"><br>
          <div id="content">
            <span class="sectionheader">Press Room
            </span><br>
            <img src="/images/pixel.gif" width="1" height="15" alt="" border="0"><br>

            <span class="largetext">Here's the latest from our press room.
            </span>

            <br clear="all">
          </div><br>
        </td>
        <td>
          <!-- a tiny chunk of space at the right -->
          <img height="5" alt="" src="/images/pixel.gif" width="1" border="0"><br>
        </td>
    <tr>
</tbody>
</table>

<?php

$num = 1;

// show summary of what's in 'usr' directory
function show_summary ( $dir )
{
  global $summary;
  global $num;

  $dir = getcwd().'/rights/pressroom/'.$dir;
  //echo $dir.'<br>';

  // Open a known directory, and proceed to read its contents
  if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
      while (($file = readdir($dh)) !== false) {

	//echo 'file = '.$file.'<br>';

	// must be .html file extension
	$pos = strrpos($file,'.');
	if ( $pos === false ) {
	  // no .
	  continue;
	}
	$ext = substr ($file , $pos+1, strlen($file) - $pos);
	if ( 'html' != $ext ) {
	  continue;
	}

	// get just the file name without extension
	$pos = strrpos($file,'/');
	if ( !($pos === false) ) {
	  // found - further work needed
	  $nam = substr ($file , $pos, strlen($file) - $pos);
	} else {
	  $nam = $file;
	}
	$pos = strrpos($nam,'.');
	if ( !($pos === false) ) {
	  $nam = substr ($nam , 0, $pos );
	}
	$tmp = $nam;

	if ( 'Summary' == $nam ) {
	  continue;
	}

	// replace all _ with spaces in $nam
	$nam = str_replace( '_', ' ', $nam);

	//echo "filename: $file : filetype: " . filetype($dir . $file) . "\n";
	//show_right( $tmp, $nam );

	$num = 1;
	$title = $nam;
	$subpage = $tmp;

	//$subpage = 'First_Issue';
	//$title = 'First Issue';

	get_issue_summary ( $tmp );
	$body = $summary;

	if ( strlen($summary) > 0 ) {
	  show_issue( $num, $subpage, $title, $body );
	  $num += 1;
	}

      }
      closedir($dh);
    }
  }
}

show_summary ( 'usr' );

if ( 0 ) {
  // first issue
  $num = 1;
  $subpage = '1';
  $title = 'Campaign Organization Begins';
  $body = 'Our campaign organization is starting to take shape.';
  show_issue( $num, $subpage, $title, $body );
}

?>

<!--- END LEFT COLUMN --->


