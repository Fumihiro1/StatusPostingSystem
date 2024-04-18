<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Web Development Assignment 1</title>
    <link rel="stylesheet" href="style.css" type="text/css" /> 
</head>
<body>
<div class-"content">
<div class="container">

    <h1>Status Posting System</h1>

<?php
    // Include database connection settings
    require_once('../../files/settings.php');

    // Establish database connection
    $conn = mysqli_connect($host, $user, $pswd, $dbnm);

    // Check if connection is successful
    if (!$conn) {
        echo "<p>Database connection failure</p>";
    } else {
        //Validate input string
        if(isset($_GET["Search"]) && !empty($_GET["Search"])){
            // Retrieve and sanitize search string
            $searchString = mysqli_real_escape_string($conn, $_GET["Search"]);

            //Check if the table exists
            $tableName = "status_table";
            $sqlCheckTable = "SHOW TABLES LIKE '$tableName'";
            $result = mysqli_query($conn, $sqlCheckTable);

            if (mysqli_num_rows($result) == 0) {
                echo 'No status found in the system. Please go to the post status page to post one.';
                echo '<p><a href="poststatusform.php">Post a new Status</a></p>';
            } else {
                //Search for matching status records
                $sqlSearch = "SELECT * FROM $tableName WHERE st LIKE '%$searchString%'";
                $searchResult = mysqli_query($conn, $sqlSearch);

                if (mysqli_num_rows($searchResult) == 0) {
                    echo 'Status not found. Please try a different keyword.';
                    echo '<p><a href="searchstatusform.html">Search for another status</a></p>';
                    echo '<p><a href="index.html">Return to Home Page</a></p>';
                } else {
                    // Display matching status records
                    echo "<h2>Status Information:</h2>";
                    while ($row = mysqli_fetch_assoc($searchResult)) {
                        echo "<p>Status Code: {$row['stcode']}</p>";
                        echo "<p>Status: {$row['st']}</p>";
                        echo "<p>Share: {$row['share']}</p>";
                        // Reformat date from yyyymmdd to ddmmyyyy
                        $formattedDate = date('d/m/Y', strtotime($row['date']));
                        echo "Date: ".$formattedDate;
                        echo "<p>Permissions: {$row['permissions']}</p>";
                        echo "<br/>";
                    }
                    echo '<p><a href="searchstatusform.html">Search for another status</a></p>';
                    echo '<p><a href="index.html">Return to Home page</a></p>';
                }
            }
        } else {
            // Input string is empty
            echo "The search string is empty. Please enter a keyword to search";
            echo '<p><a href="searchstatusform.html">Search for another status</a></p>';
            echo '<p><a href="index.html">Return to Home Page</a></p>';
        }
    }
    // Close the database connection
    mysqli_close($conn);
?>
</div>
</div>
</body>
</html>
