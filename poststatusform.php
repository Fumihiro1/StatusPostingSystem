<!-- 
    This HTML document defines a form for posting status updates.
-->

<?php
date_default_timezone_set('Pacific/Auckland'); // Ensuring timezone is set to the NZ default
?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Assignment 1</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <!-- Container for the entire content -->
    <div class="container">
        <h1>Status Posting System</h1>
        
        <!-- Form for posting status updates -->
        <form action="poststatusprocess.php" method="POST">
            
            <!-- Input field for status code -->
            <label for="stcode">Status Code:</label>
            <input type="text" name="stcode" id="stcode" required placeholder="S0001">
            <br/><br/>
            
            <!-- Input field for status message -->
            <label for="st">Status:</label>
            <input type="text" name="st" id="st" required>
            <br/><br/>
            
            <!-- Radio buttons for choosing sharing options -->
            <label>Share:</label>
            <input type="radio" name="share" value="University" required> University
            <input type="radio" name="share" value="Class"> Class
            <input type="radio" name="share" value="Private"> Private
            <br/><br/>
            
            <!-- Input field for date with default value set to current date -->
            <label for="date">Date:</label>
	    <input type="text" name="date" id="date" required pattern="\d{1,2}/\d{1,2}/\d{4}" placeholder="<?php echo date('d/m/Y'); ?>">
	    <br/><br/>
            
            <!-- Checkboxes for specifying permission options -->
            <label for="permission">Permission:</label>
            <input type="checkbox" name="permission[]" value="Allow Like"> Allow Like
            <input type="checkbox" name="permission[]" value="Allow Comments"> Allow Comments
            <input type="checkbox" name="permission[]" value="Allow Share"> Allow Share
            <br/><br/>
            
            <!-- Submit button for submitting the form -->
            <input type="submit" value="Submit" class="submit-button">
        </form>

        <!-- Link to return to the home page -->
        <a href="index.html">Return to Home Page</a>
    </div>
</body>
</html>
