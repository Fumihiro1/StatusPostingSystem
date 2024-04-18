<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Web Development Assignment 1</title>
    <link rel="stylesheet" href="style.css" type="text/css" /> 
</head>
<body>
<div class="container">
    <h1>Status Posting System</h1>
<?php
    // Include database connection settings
    require_once('settings.php');

    // Establish database connection
    $conn = mysqli_connect($host, $user, $pswd, $dbnm);

    // Check if connection is successful
    if (!$conn) {
        echo "<p>Database connection failure</p>";
    } else {
	//Query the database to ensure the table exists
        $tableName = "status_table";
        $sqlCheckTable = "SHOW TABLES LIKE '$tableName'";
        $result = mysqli_query($conn, $sqlCheckTable);
        
	//Ensure the user cannot reset a table that doesn't exist
        if (mysqli_num_rows($result) == 0) {
            echo "<p>The database table has already been reset.</p>";
        } else {
	    //Reset the table
            $sqlString = "DROP TABLE $tableName";  
            $queryResult = @mysqli_query($conn, $sqlString);
            
            if ($queryResult) {
                echo "<p>Successfully reset the database table.</p>"; 
            } else {
                echo "<p>Unable to execute the query.</p>";
                echo "<p>Error code " . mysqli_errno($conn) . ": " . mysqli_error($conn) . "</p>";  
            }
        }
        
        // Close the database connection
        mysqli_close($conn);
    }
?>

<a href="index.html">Return to Home Page</a><br/>
</div>
</body>
</html>
