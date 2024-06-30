<?php
// right_col.php

// show what's in 'usr' directory
function show_usr ( $dir )
{
  $dir = getcwd().'/rights/pressroom/'.$dir;
  //echo $dir.'<br>';

  // Open a known directory, and proceed to read its contents
  if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
      while (($file = readdir($dh)) !== false) {

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
	show_right( $tmp, $nam );

      }
      closedir($dh);
    }
  }
}

// show a right column entry
function show_right ( $issue, $title )
{
  $tmp = "<tr>
    <td align='left'>
      <img height='1' alt='' src='/images/divider_line1.gif' width='250' border='0'><br>
      <img height='4' alt='' src='/images/pixel.gif' width='1' border='0'><br>
      <a href='?page=pressroom&subpage=%ISSUE%'>&gt; %TITLE%</a><br>
    </td>
  </tr>";

  $tmp = str_replace ( '%ISSUE%', $issue, $tmp);
  $tmp = str_replace ( '%TITLE%', $title, $tmp);
  echo $tmp;
}

?>

<table cellpadding="2" cellspacing="1" border="0" style="width: 250px; text-align: left; margin-left: auto; margin-right: auto;">
<tbody>
  <tr>
    <td>
      Articles<br>
    </td>
  </tr>

<?php

show_usr ( 'usr' );

//show_right ( '1', 'Campaign Organization Begins' );
//show_right ( 'taxes'      , 'Taxes' );
//show_right ( 'wot'        , 'Homeland Security and War on Terror' );

//show_right ( 'jobs', 'Jobs' );
?>

  <tr>
    <td>
      <img height='1' alt='' src='/images/divider_line1.gif' width='250' border='0'><br>
    </td>
  </tr>

</tbody>
</table>
