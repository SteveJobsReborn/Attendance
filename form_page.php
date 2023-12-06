<?php

session_start();
include 'connection.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Create a new database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Trim and escape the input to protect against SQL injection
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));

    // Prepare the SQL statement
    $attendanceDate = date("Y-m-d");
    $checkQuery = "SELECT * FROM names WHERE name = '$name' AND attendanceDate = '$attendanceDate'";
    $result = $conn->query($checkQuery);
    $stmt = $conn->prepare("INSERT INTO names (name, attendanceDate) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $attendanceDate);

    
    if ($result && $result->num_rows > 0) {
        echo "Attendance already submitted for this student on this date.";
    } else{
    // Execute the prepared statement
    if ($stmt->execute()) {
        // Redirect to index.php after successful insertion
        header('Location: index.php');
        exit;
    } else {
        // Handle error appropriately
        echo "Error: " . $stmt->error;
    }
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Your Name</title>
</head>

<body translate="no" >
<link rel="stylesheet" href="style.css">
<div id='stars'></div>
<div id='stars2'></div>
<div id='stars3'></div>
<div id='title'>
    <form method="post" action="form_page.php" id="nameForm">
        <input type="text" name="name" placeholder="Enter your name" required>
        <input type="submit" id="submitBtn" value="Submit">
        <img src="media/loading.gif" alt="Loading" class="loader" id="loader">
    </form>
</div>

    <script>
        document.getElementById('nameForm').onsubmit = function(event) {
            event.preventDefault();
            var submitBtn = document.getElementById('submitBtn');
            var loader = document.getElementById('loader');
            submitBtn.disabled = true;  // Prevent multiple submissions
            loader.style.display = 'inline';  // Show loading GIF

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'form_page.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    loader.style.display = 'none';  // Hide loading GIF
                    submitBtn.disabled = false;
                    if (xhr.status == 200) {
                        alert('Name submitted!');
                        window.location = 'index.php'; // Redirect back to the board
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                }
            };
            var formData = 'name=' + encodeURIComponent(document.getElementsByName('name')[0].value);
            xhr.send(formData);
        };
    </script>
</body>
</html>