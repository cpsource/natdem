<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Sidebar Menu Example</title>
    <!-- Bootstrap CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <style>
        /* Custom CSS for the sidebar */
        body {
            display: flex;
            flex-direction: column;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            background-color: #343a40;
            padding-top: 20px;
            min-height: 100vh;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 15px;
            text-decoration: none;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #495057;
            color: #f8f9fa;
        }

        .content {
            padding: 20px;
            background-color: #f8f9fa;
            flex: 1;
        }

        @media (max-width: 768px) {
            .sidebar {
                min-width: 100%;
                max-width: 100%;
                min-height: auto;
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

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 sidebar">
                <h3 class="text-center text-light">Menu</h3>
                <a href="#home">Home</a>
                <a href="#services">Services</a>
                <a href="#about">About</a>
                <a href="#contact">Contact</a>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 col-lg-10 content">
                <h1>Welcome to My Website</h1>
                <p>This is a simple web page with a sidebar menu on the left. The sidebar is responsive and will adjust its size depending on the screen size.</p>
                <p>Use the menu on the left to navigate to different sections of the page.</p>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="/js/bootstrap.js"></script>
</body>
</html>

