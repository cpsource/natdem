<?php
// Generate a random nonce
$nonce = base64_encode(random_bytes(16));

// Set the CSP header with the dynamic nonce (For dynamic, move from .htaccess)
header("Content-Security-Policy: script-src 'strict-dynamic' 'nonce-$nonce' 'unsafe-inline' http: https:; object-src 'none'; base-uri 'none'; require-trusted-types-for 'script'; report-uri https://csp.natdem.org;");

//header("Content-Security-Policy: script-src 'strict-dynamic' nonce-$nonce 'unsafe-inline' http: https:; object-src 'none'; base-uri 'none'; require-trusted-types-for 'script'; report-uri https://csp.natdem.org;

// Now you can use the nonce in your HTML
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <!-- Importing Google Font (Roboto) -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .right-column {
            flex: 1; /* Take up the remaining space */
            background-color: #f8f9fa; /* Light background color */
            padding: 20px;
            box-sizing: border-box; /* Ensure padding is included in the width */
	    ?>
        }
    </style>
</head>
<body>

<?php
// Get the full domain name (e.g., csp.example.com)
$fullDomain = $_SERVER['HTTP_HOST'];

// Split the domain into parts
$domainParts = explode('.', $fullDomain);

// Check if the first part (subdomain) is "csp"
if ($domainParts[0] === 'csp') {
    // Code to execute if the subdomain is "csp"
    echo '<h1>Welcome to the CSP subdomain</h1>';
    // You can include other logic here, such as redirecting, logging, or serving specific content
    // Redirect to a specific page if the subdomain is "csp"
    header('Location: https://natdem.org');
    exit();
} else {
    // Code to execute for other subdomains or the main domain
    //echo '<h1>Welcome to the main site or another subdomain: ' . $fullDomain . '</h1>';
}
?>

<!-- Include Header -->
<?php include 'header.php'; ?>

<div class="container">
    <div class="left-column">
      <nav class="mt-1">
        <h3 class="text-center text-light">Menu</h3>
	<ul>
          <li><a href="/?page=author">The Author</a></li>
          <li><a href="/?page=book">The Book</a></li>
          <li><a href="/?page=pressroom">Press Room</a></li>
          <li><a href="/?page=udohr">Human Rights</a></li>
          <li><a href="/?page=greatgoals">Great Goals</a></li>
          <li><a href="/?page=fullpotential">Humanity Reaching Full Potential</a></li>
          <li><a href="/?page=family-pictures">Family Pictures</a></li>
          <li><a href="/?page=obituary">Obituary</a></li>
          <li><a href="/?page=bombs">Atomic Bombs</a></li>
          <li><a href="/?page=secretariat">UN Secretariat</a></li>
          <li><a href="/?page=end9">Music and Parting Words</a></li>
	</ul>
      </nav>
    </div>
    <div class="right-column">
        <?php include 'rights/index.php'; ?>
    </div>
</div>

<!-- Include Footer -->
<?php include 'footer.php'; ?>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.1/js/bootstrap.bundle.min.js nonce="<?php echo $nonce; ?>">
</script>

</body>
</html>

