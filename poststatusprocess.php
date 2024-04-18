<!-- 
    This HTML document contains PHP code for processing and storing status updates in a database.
-->

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Assignment 1</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="content">
<div class="container">

<?php

// Include database connection settings
require_once('../../files/settings.php');

// Establish database connection
$conn = mysqli_connect($host, $user, $pswd, $dbnm);

// Check if connection is successful
if (!$conn) {
    echo "<p>Database connection failure</p>";
} else {

    // Check if the database table exists, if not, create it
    $tableName = "status_table";
    $sqlCheckTable = "SHOW TABLES LIKE '$tableName'";
    $result = mysqli_query($conn, $sqlCheckTable);
    
    if (mysqli_num_rows($result) == 0) {
        $sqlCreateTable = "CREATE TABLE $tableName (
            stcode VARCHAR(10) NOT NULL UNIQUE,
            st TEXT NOT NULL,
            share VARCHAR(20) NOT NULL,
            date DATE NOT NULL,
            permissions TEXT
        )";
        mysqli_query($conn, $sqlCreateTable);
    }

    	// Function to display error message
	function displayError($message) {
	    echo '<h1>Status Posting System</h1>';
    	    echo "<p>Error: $message</p>";
    	    echo '<p><a href="poststatusform.php">Return to Post Status page</a></p>';
	}

	// Function to display confirmation message
	function displayConfirmation() {
	    echo '<h1>Status Posting System</h1>';
    	    echo '<p>Congratulations! The status has been posted!</p>';
    	    echo '<p><a href="index.html">Return to Home page</a></p>';
	}

    // Processing form submission
    if (isset($_POST['stcode']) && isset($_POST['st']) && isset($_POST['share']) && isset($_POST['date']) && isset($_POST['permission'])) {
        $stcode = mysqli_real_escape_string($conn, $_POST['stcode']);
        $st = mysqli_real_escape_string($conn, $_POST['st']);
        $share = mysqli_real_escape_string($conn, $_POST['share']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $permissions = implode(', ', $_POST['permission']); // Convert array to comma-separated string

        // Validating input data, check for the correct formatting as provided in the assignment spec
        if (!preg_match('/^S\d{4}$/', $stcode)) {
            displayError('Wrong format! The status code must start with an "S" followed by four digits, like "S0001".');
        }
        elseif (!preg_match('/^[a-zA-Z0-9,.\s!?]+$/', $st)) {
            displayError('Your status is in a wrong format! The status can only contain alphanumericals and spaces, comma, period, exclamation point and question mark and cannot be blank!');
        }
        elseif (!DateTime::createFromFormat('d/m/Y', $date)) {
            displayError('Invalid date format! Please use the format dd/mm/yyyy.');
        } else {
            // Check if status code already exists
            $sqlCheckCode = "SELECT * FROM $tableName WHERE stcode = '$stcode'";
            $result = mysqli_query($conn, $sqlCheckCode);

            if (mysqli_num_rows($result) > 0) {
                displayError('The status code already exists. Please try another one!');
            } else {
                // Insert status into the database
                $sqlInsert = "INSERT INTO $tableName (stcode, st, share, date, permissions) VALUES ('$stcode', '$st', '$share', STR_TO_DATE('$date', '%d/%m/%Y'), '$permissions')";
                if (mysqli_query($conn, $sqlInsert)) {
                    displayConfirmation();
                } else {
                    displayError('Error storing status in the database.');
                }
            }
        }
    } else {
        // Display error if mandatory fields are missing
        displayError('Status code, status, share, date, and permission are mandatory fields.');
    }

    // Close database connection
    mysqli_close($conn);
}

?>

</div>
</div> <!-- End of .content -->

</body>
</html>
