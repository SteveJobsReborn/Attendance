
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            height: 100vh; /* Full height of the viewport */
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }
        input[type=text] {
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type=submit] {
            padding: 10px 20px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background-color: #4cae4c;
        }
        input[type="submit"]:disabled {
            background-color: #ccc;
        }

        .loader {  
            display: none;
            vertical-align: middle;
			width: 20px;
			height: 20px;
        }
    </style>
</head>
<body>
    <form method="post" action="form_page.php" id="nameForm">
        <input type="text" name="name" placeholder="Enter your name" required>
        <input type="submit" id="submitBtn" value="Submit">
        <img src="media/loading.gif" alt="Loading" class="loader" id="loader">
    </form>

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