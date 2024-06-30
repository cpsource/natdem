<!DOCTYPE html>
<html>
<head>
  <title>Page Family Photos</title>

  <style>
    /* ... (same CSS as before) ... */
  table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
    border: medium solid black; /* Added medium border to the table */
  }
  td, th {
    border: medium solid black; /* Added medium border to cells */
    padding: 10px;
    vertical-align: top;
  }
  img {
    max-width: 100%;
    height: auto;
  }
  </style>

</head>
<body>

  
<table>
  <tr>
    <th>William R. Page Family Pictures</th>
    <th>Description</th>
  </tr>

<?php
// Define the directory to scan
$directory = 'rights/family-pictures/.'; // Replace with actual path
// Open the directory
if ($handle = opendir($directory)) {

    // Loop through all the files in the directory
    while (false !== ($entry = readdir($handle))) {

        // Check if the file is a JPG image
        if (preg_match('/\.jpe?g$/i', $entry)) { 
            echo "<tr>";
            echo "<td><img src='$directory/$entry' alt='$entry'></td>";
            echo "<td>$entry</td>"; 
            echo "</tr>";
        }
    }

    closedir($handle);
} else {
    echo "Unable to open directory: $directory";
}
?>

</table>

</body>
</html>
