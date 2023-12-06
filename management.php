<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administration Console</title>

    <style>
		body {
			height: 100%;
			width: 100%;
			padding: 0;
            margin: 0;
		}
		.banner {
			display: flex;
			block-size: 70px;
			background-color: rgba(0, 0, 139, 0.87);
			align-items: left;
			position: sticky;
			top: 0;
			z-index: 9999;
			backdrop-filter: blur(100px);
		}

        .context form {
            margin: 20px 10px;
            text-align: center;
        }

        .context label {
            font-weight: bold;
        }

        .context input[type="date"] {
            padding: 8px;
            font-size: 16px;
        }

        .context input[type="submit"] {
            padding: 8px 20px;
            font-size: 16px;
            background-color: #00227b;
            color: white;
            border: none;
            cursor: pointer;
        }

        .context input[type="submit"]:hover {
            background-color: #0042d1;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 20px 10px;
        }

        li {
            margin-bottom: 10px;
        }

        form.inline-form {
            display: inline;
        }

        .remove-button {
            padding: 5px 10px;
            font-size: 14px;
            background-color: #ff6347;
            color: white;
            border: none;
            cursor: pointer;
        } 

        .remove-button:hover {
            background-color: #ff0000;
        }

        /*****************************************************************************************/
        @import url('https://fonts.googleapis.com/css?family=Exo:400,700');


        body{
            font-family: 'Exo', sans-serif;
        }


        .context {
            width: 100%;
            position: absolute;
            top:50vh;
            z-index: 1;
            
        }

        .context h1{
            text-align: center;
            color: #fff;
            font-size: 50px;
        }

        .context h2{
            text-align: center;
            color: black;
        }


        .area{
            background: #4e54c8;  
            background: -webkit-linear-gradient(to left, #8f94fb, #4e54c8);  
            width: 100%;
            height:100vh;
            
        
        }

        .circles{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .circles li{
            position: absolute;
            display: block;
            list-style: none;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.2);
            animation: animate 25s linear infinite;
            bottom: -150px;
            
        }

        .circles li:nth-child(1){
            left: 25%;
            width: 80px;
            height: 80px;
            animation-delay: 0s;
        }


        .circles li:nth-child(2){
            left: 10%;
            width: 20px;
            height: 20px;
            animation-delay: 2s;
            animation-duration: 12s;
        }

        .circles li:nth-child(3){
            left: 70%;
            width: 20px;
            height: 20px;
            animation-delay: 4s;
        }

        .circles li:nth-child(4){
            left: 40%;
            width: 60px;
            height: 60px;
            animation-delay: 0s;
            animation-duration: 18s;
        }

        .circles li:nth-child(5){
            left: 65%;
            width: 20px;
            height: 20px;
            animation-delay: 0s;
        }

        .circles li:nth-child(6){
            left: 75%;
            width: 110px;
            height: 110px;
            animation-delay: 3s;
        }

        .circles li:nth-child(7){
            left: 35%;
            width: 150px;
            height: 150px;
            animation-delay: 7s;
        }

        .circles li:nth-child(8){
            left: 50%;
            width: 25px;
            height: 25px;
            animation-delay: 15s;
            animation-duration: 45s;
        }

        .circles li:nth-child(9){
            left: 20%;
            width: 15px;
            height: 15px;
            animation-delay: 2s;
            animation-duration: 35s;
        }

        .circles li:nth-child(10){
            left: 85%;
            width: 150px;
            height: 150px;
            animation-delay: 0s;
            animation-duration: 11s;
        }



        @keyframes animate {

            0%{
                transform: translateY(0) rotate(0deg);
                opacity: 1;
                border-radius: 0;
            }

            100%{
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
                border-radius: 50%;
            }

        }
    </style>
</head>
<body>
    <div class = "banner">
		<img src = "https://www.xmu.edu.my/_upload/tpl/08/9f/2207/template2207/htmlRes/xxde_022.png" alt = "XMUM Logo" >
	</div>

    <div class="context">
        <h1>Administration Console</h1>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="date">Select Date:</label>
        <input type="date" id="date" name="date">
        <input type="submit" value="View Students">
        </form>

        <?php
        include 'connection.php';

        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['date'])) {
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $selectedDate = $_POST['date'];

            $sql = "SELECT * FROM names WHERE attendanceDate = '$selectedDate'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<h2>Students on $selectedDate:</h2>";
                echo "<ul>";
                while($row = $result->fetch_assoc()) {
                    echo "<li>{$row['name']} - <form method='POST' action='{$_SERVER['PHP_SELF']}' style='display: inline;'><input type='hidden' name='id' value='{$row['id']}'><input type='submit' name='remove' value='❌'></form></li>";
                }
                echo "</ul>";
            } else {
                echo "<h2>No students found for the selected date.</h2>";
            }

            $conn->close();
        }
        ?>

        <?php
        include 'connection.php';
        // Handle removing the student
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove'])) {

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $id = $_POST['id'];

            $sql = "DELETE FROM names WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                echo "Student removed successfully.";
            } else {
                echo "Error removing student: " . $conn->error;
            }

            $conn->close();
        }
        ?>
    </div>


    <div class="area" >
                <ul class="circles">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                </ul>
    </div >




</body>
</html>