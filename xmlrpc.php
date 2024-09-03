<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>XMLRPC Login</title>
    <!-- Bootstrap 3 CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        .video-container {
            display: flex;
            justify-content: flex-start;
            margin-left: 33%; /* Position the video about 1/3 across the page */
            margin-bottom: 20px;
        }
        .video-container iframe {
            width: 100%;
            max-width: 300px;
            aspect-ratio: 16 / 9;
            height: auto;
        }
    </style>
    <script>
        var videoWatched = false;

        function markVideoAsWatched() {
            videoWatched = true;
            document.getElementById("videoMessage").style.display = "none";
        }

        function validateForm() {
            if (!videoWatched) {
                document.getElementById("videoMessage").style.display = "block";
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Before we allow you to login as root, we must be sure you are not a robot.</h1>
                <h3 class="text-center">Please answer the following questions.</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="electionQuestion">Was the election stolen in 2020 by the Democrats?</label>
                        <select class="form-control" id="electionQuestion" name="electionAnswer">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <button type="submit" name="firstSubmit" class="btn btn-primary">Check Answer</button>
                </form>
            </div>
        </div>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['firstSubmit'])) {
            $answer = $_POST['electionAnswer'];
            if ($answer == 'Yes') {
                echo '<p class="text-danger">Sorry, this simply isn\'t true. In court, Trump lost sixty out of sixty-one challenges. Biden was clearly the winner.</p>';
                exit();
            } else {
                echo '<p class="text-success">Thank you for your response. Please proceed with the next question.</p>';
                displaySecondQuestion();
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['secondSubmit'])) {
            $selectedSigns = isset($_POST['dementiaSigns']) ? $_POST['dementiaSigns'] : [];
            $correctAnswers = array("Slurring Words", "Stooped Posture", "Incoherent Speech", "Mixes Fiction and Reality");

            displaySecondQuestion($selectedSigns);

            if (count(array_diff($correctAnswers, $selectedSigns)) === 0 && count(array_diff($selectedSigns, $correctAnswers)) === 0) {
                echo '<p class="text-success">Thank you for your response. Please proceed with the next steps.</p>';
            } else {
                echo '<p class="text-danger">Incorrect. All of these traits are true.</p>';
                exit();
            }
        }

        function displaySecondQuestion($selectedSigns = []) {
            echo '<div class="row">
                    <div class="col-md-12">
                        <p>Before we ask this question, you must watch this video. We will then ask you a question about it.</p>
                        <div class="video-container">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/BERAlXY54BA" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen onclick="markVideoAsWatched()"></iframe>
                        </div>
                        <div id="videoMessage" class="alert alert-danger" style="display:none;">
                            Please watch the video before answering the question.
                        </div>
                        <form method="post" action="" onsubmit="return validateForm()">
                            <div class="form-group">
                                <label for="dementiaQuestion">From the video, what dementia signs is Trump showing?</label>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="dementiaSigns[]" value="Slurring Words" ' . (in_array("Slurring Words", $selectedSigns) ? "checked" : "") . '> Slurring Words</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="dementiaSigns[]" value="Stooped Posture" ' . (in_array("Stooped Posture", $selectedSigns) ? "checked" : "") . '> Stooped Posture</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="dementiaSigns[]" value="Incoherent Speech" ' . (in_array("Incoherent Speech", $selectedSigns) ? "checked" : "") . '> Incoherent Speech</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="dementiaSigns[]" value="Mixes Fiction and Reality" ' . (in_array("Mixes Fiction and Reality", $selectedSigns) ? "checked" : "") . '> Mixes Fiction and Reality</label>
                                </div>
                            </div>
                            <button type="submit" name="secondSubmit" class="btn btn-primary">Check Response</button>
                        </form>
                    </div>
                </div>';
        }
        ?>
    </div>

    <!-- Bootstrap 3 JS and dependencies -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>

