<?php
require 'Parsedown.php';

$parsedown = new Parsedown();

// Load the Markdown file
$markdown = file_get_contents('content.md');

// Convert Markdown to HTML
$html = $parsedown->text($markdown);

// Output the HTML
echo $html;
?>

