<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="/css/bootstrap.css" rel="stylesheet">
    <style>
        .container-fluid-s {
            display: flex;
            padding: 0;
            margin: 0;
	    min-height: 100vh;
            margin-left: 20px;
        }

        .sidebar {
            background-color: #a3d9a5; /* Slightly darker green background */
            padding-top: 20px;
            width: 15%; /* Sidebar takes up 20% of the parent container's width */
	    min-height: 100vh;
            margin-left: 0px;
        }

        .sidebar a {
            display: block;
            color: black;
            padding: 15px;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
        }

        .sidebar a:hover {
            background-color: #495057;
            color: #f8f9fa;
        }

        .content {
            flex: 1; /* Main content takes up the remaining space */
            padding: 20px;
            background-color: #f8f9fa;
        }

        @media (max-width: 768px) {
            .container-fluid-s {
                flex-direction: column;
                max-width: 1200px;
                width: 100%;
                margin: 0 auto;
            }

            .sidebar {
                width: 100%;
		min-height: auto;
                margin-left: 0;
            }

            .sidebar a {
                text-align: center;
            }

            .content {
                padding-top: 20px;
            }
        }
        
    </style>
</head>
<body>

<!-- Include Header -->
<?php include 'header.php'; ?>

<div class="container-fluid container-fluid-s">
    <nav class="sidebar">
        <h3 class="text-center text-light">Menu</h3>
        <a href="/?page=author">The Author</a>
        <a href="/?page=book">The Book</a>
        <a href="/?page=pressroom">Press Room</a>
        <a href="/?page=udohr">Human Rights</a>
        <a href="/?page=greatgoals">Great Goals</a>
        <a href="/?page=fullpotential">Humanity Reaching Full Potential</a>
        <a href="/?page=family-pictures">Family Pictures</a>
        <a href="/?page=obituary">Obituary</a>
        <a href="/?page=bombs">Atomic Bombs</a>
        <a href="/?page=secretariat">UN Secretariat</a>
        <a href="/?page=end9">Music and Parting Words</a>						
    </nav>

    <div class="content">
        <?php include 'rights/index.php'; ?>
    </div>
</div>

</body>
</html>

