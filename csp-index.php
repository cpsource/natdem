<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSP Report Listener</title>
</head>
<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the JSON data from the request
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        // Extract the 'csp-report' field
        $report = isset($data['csp-report']) ? $data['csp-report'] : null;

	file_put_contents('csp-reports.log', json_encode($data) . PHP_EOL, FILE_APPEND);

        if ($report) {
            // Log to a specific log file
            file_put_contents('csp-reports.log', json_encode($report) . PHP_EOL, FILE_APPEND);

            // Print the report to the screen (for debugging purposes)
            //echo '<pre>CSP Violation: ' . htmlspecialchars(json_encode($report, JSON_PRETTY_PRINT)) . '</pre>';
        }

        // Return a 204 No Content response
        http_response_code(204);
        exit();
    }
    ?>
    <h1>CSP Report Listener</h1>
    <p>This page is used to receive and log CSP reports.</p>
</body>
</html>

