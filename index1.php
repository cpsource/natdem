<?php
// Generate a random nonce for CSP
$nonce = base64_encode(random_bytes(16));
// Set the CSP header with the dynamic nonce (For dynamic, move from .htaccess)
header("Content-Security-Policy: script-src 'strict-dynamic' 'nonce-$nonce' 'unsafe-inline' http: https:; object-src 'none'; base-uri 'none'; require-trusted-types-for 'script'; report-uri https://csp.natdem.org;");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Example with Nonce</title>
    <!-- Bootstrap CSS from jsDelivr CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" nonce="<?php echo $nonce; ?>">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Hello, World!</h1>
        <p>This is a simple Bootstrap page with jQuery and Popper.js included.</p>
        <button class="btn btn-primary" id="myButton">Click Me</button>
    </div>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" nonce="<?php echo $nonce; ?>"></script>
    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js" nonce="<?php echo $nonce; ?>"></script>
    <!-- Bootstrap JS from jsDelivr CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" nonce="<?php echo $nonce; ?>"></script>

   <script nonce="<?php echo $nonce; ?>">
    // Ensure jQuery is fully loaded before executing the script
    $(document).ready(function() {
        $('#myButton').click(function() {
            alert('Button clicked!');
        });
    });
    </script>

    <!-- Include the Trusted Types policy script -->
    <script nonce="<?php echo $nonce; ?>">
    // Create a Trusted Types policy
    const myPolicy = window.trustedTypes.createPolicy('default', {
        createHTML: (input) => input,  // Here, you can sanitize or validate the input
    });
    // Use the policy to assign TrustedHTML to innerHTML
    const contentElement = document.getElementById('content');
    contentElement.innerHTML = myPolicy.createHTML('<p>Safe content assigned with TrustedHTML</p>');
    </script>
</body>
</html>

