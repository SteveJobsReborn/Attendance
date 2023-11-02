<?php
// The data you want to encode in the QR code
$data = 'localhost/form_page.php';
// $data = 'https://forms.office.com/Pages/ResponsePage.aspx?id=00dqnpUnl0ueUnixBgYp8QNaw1i-Q7BAvo2qfTNr5Q9UQ01OWEVHTzg3U1AyWUlFRzVHM05KWE9QVy4u';


// The API endpoint with the data and size parameters
$qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($data);

// Use file_get_contents to fetch the image data
$qrImage = file_get_contents($qrApiUrl);

// Encode the image data into base64
$qrBase64 = base64_encode($qrImage);

if (isset($_GET['action']) && $_GET['action'] === 'getNames') {
    // Path to the text file that stores names
    $namesFile = 'names.txt';

    // Load the names already submitted
    $names = file_exists($namesFile) ? file($namesFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

    // Output the names as JSON
    header('Content-Type: application/json');
    echo json_encode($names);
    exit; // Make sure to terminate the script so it doesn't run the HTML part
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Generator</title>
    <style>
        /* Center the content on the page */
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center; /* Ensure text is centered within the flex item */
        }
        h1 {
            margin: 0;
            font-size: 2em; /* You can adjust the font size if needed */
            padding-bottom: 20px; /* Add some space between the title and the QR code */
        }
        img {
            /* Adjust as needed to make the QR code fit well on your page */
            width: 150px;
            height: 150px;
        }
        /* Ensure the image does not exceed the bounds of the screen */
        @media (max-width: 160px) {
            img {
                width: 100px;
                height: 100px;
            }
        }

    </style>
</head>
<body>
    <h1>Student, Please Scan Here for Attendance!</h1>
    <!-- Display the QR code -->
    <img src="data:image/png;base64, <?php echo $qrBase64; ?>" alt="QR Code">


<!-- The board where names will be displayed -->
    <div id="board">
        <h2>Attendance Board</h2>
        <ul id="nameList"></ul>
    </div>

    <script>
    // Function to update the board
    function updateBoard() {
        const xhr = new XMLHttpRequest();
        // Assuming the PHP code to return names is part of index.php, we add a query string to distinguish the request
        xhr.open('GET', 'index.php?action=getNames', true);
        xhr.onload = function() {
            if (this.status === 200) {
                // Parse the JSON response
                const names = JSON.parse(this.responseText);
                const nameList = document.getElementById('nameList');
                nameList.innerHTML = ''; // Clear the current list
                names.forEach(function(name) {
                    const li = document.createElement('li');
                    li.textContent = name;
                    nameList.appendChild(li);
                });
            }
        };
        xhr.send();
    }

    // Call updateBoard every 5 seconds to get new names
    setInterval(updateBoard, 5000);
    updateBoard(); // Also update when the page loads
</script>
</body>
</html>