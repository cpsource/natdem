<!DOCTYPE html>
<html>
<head>
  <title>Page Family Photos</title>
</head>
<body>

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
  
<table>
  <tr>
    <th>Family Picture</th>
    <th>Description</th>
  </tr>

<?php
// Define the directory to scan
$directory = './'; // Replace with actual path
echo "directory = $directory";
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
