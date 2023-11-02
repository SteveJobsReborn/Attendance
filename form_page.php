<?php
// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    // Save the name to a text file
    file_put_contents('names.txt', $name . PHP_EOL, FILE_APPEND);
    // Redirect back to the index.php or just inform the user
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Your Name</title>
</head>
<body>
    <form method="post" action="form_page.php" id="nameForm">
        <input type="text" name="name" placeholder="Enter your name" required>
        <input type="submit" id="submitBtn" value="Submit">
    </form>

    <!-- JavaScript to enhance user experience by preventing default form submission -->
    <script>
	
        document.getElementById('nameForm').onsubmit = function(event) {
            event.preventDefault();
			document.getElementById('submitBtn').disabled = true;  // Prevent multiple submission

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'form_page.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert('Name submitted!');
                    window.location = 'index.php'; // Redirect back to the board
                } else {
					document.getElementById('submitBtn').disabled = false
				}
            };
            var formData = 'name=' + encodeURIComponent(document.getElementsByName('name')[0].value);
            xhr.send(formData);
        };
    </script>
</body>
</html>