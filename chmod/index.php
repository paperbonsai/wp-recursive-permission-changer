<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permission Changer</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Font Awesome for the loader icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- Custom CSS for loader button -->
    <style>
        /* Optional: Adjust button width to fit the loader icon */
        #startButton {
            width: 100px;
            /* Adjust as needed */
        }

        .loader-button {
            position: relative;
        }

        .loader-button .loader-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        #progressBar {
            color: #E9ECEF;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h2 class="mb-4 text-center">WP Recursive Permission Changer</h2>
                <!-- Info Window -->
                <div class="alert alert-warning alert-dismissible fade show pt-4" role="alert">
                    <ul>
                        <li>The WP Recursive Permission Changer is a tool to modify file and directory permissions recursively.</li>
                        <li>When you are done, delete the chmod directory from your hosting</li>
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="dirPerms">Directory Permissions</label>
                            <input type="text" class="form-control" id="dirPerms" placeholder="e.g., 755" value="755">
                        </div>
                        <div class="form-group">
                            <label for="filePerms">File Permissions</label>
                            <input type="text" class="form-control" id="filePerms" placeholder="e.g., 644" value="644">
                        </div>
                        <button id="startButton" class="btn btn-dark loader-button">Start
                            <span class="loader-icon" style="display: none;"><i class="fas fa-spinner fa-spin"></i></span>
                        </button>
                    </div>
                </div>
                <div class="progress mb-4" style="height: 30px">
                    <div id="progressBar" class="progress-bar  bg-dark" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div id="summaryCard" class="card mb-4" style="display: none">
                    <div class="card-body">
                        <h5 class="card-title">Process Complete</h5>
                        <p class="card-text" id="summaryText"></p>
                    </div>
                </div>
                <!-- Hardcoded Values Table -->
                <div class="card">
                    <div class="card-header">Hardcoded File Permissions</div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>File Name</th>
                                    <th>Permissions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>.htaccess</td>
                                    <td>444</td>
                                </tr>
                                <tr>
                                    <td>wp-config.php</td>
                                    <td>444</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var intervalID; // Define interval ID here 
            // Log the parent directory to the console
            console.log("Parent Directory:", "<?php echo realpath(dirname(__DIR__)); ?>");
            $("#startButton").click(function() {
                // Reset the progress bar to 0
                $("#progressBar")
                    .css("width", "0%")
                    .attr("aria-valuenow", 0)
                    .text("0% ");
                clearInterval(intervalID); // Clear any existing interval 
                var dirPerms = $("#dirPerms").val();
                var filePerms = $("#filePerms").val();
                // Show confirmation dialog
                if (!confirm("Are you sure you want to change permissions?")) {
                    return; // User cancelled the operation
                }
                // Disable the button
                $("#startButton").prop("disabled", true);
                // Show the loader icon
                $(".loader-icon").show();
                $.post("changePermissions.php", {
                    dirPerms: dirPerms,
                    filePerms: filePerms,
                }).done(function() {
                    // Request completed successfully
                    var currentProgress = 0;
                    var intervalDuration = 100; // milliseconds 
                    function updateProgress() {
                        // Gradually increase the progress
                        currentProgress += 1;
                        if (currentProgress >= 100) {
                            clearInterval(intervalID);
                            // Enable the button
                            $("#startButton").prop("disabled", false);
                            // Hide the loader icon
                            $(".loader-icon").hide();
                            // Retrieve and display time taken and processed files
                            $.get("getSummary.php", function(summaryData) {
                                var summary = JSON.parse(summaryData);
                                $("#summaryText").text(
                                    "Total items processed: " +
                                    summary.totalItems +
                                    ", Time taken: " +
                                    summary.timeTaken.toFixed(2) +
                                    " seconds"
                                );
                                $("#summaryCard").show();
                            });
                        }
                        // Update the progress bar
                        $("#progressBar")
                            .css("width", currentProgress + "%")
                            .attr("aria-valuenow", currentProgress)
                            .text(currentProgress + "%");
                    }
                    intervalID = setInterval(updateProgress, intervalDuration);
                }).fail(function() {
                    // Request failed
                    console.error("Failed to start the permission change process.");
                    // Enable the button in case of failure
                    $("#startButton").prop("disabled", false);
                    // Hide the loader icon
                    $(".loader-icon").hide();
                    // Display an error message to the user
                    alert("An error occurred while changing permissions. Please try again.");
                });
            });
        });
    </script>
</body>

</html>