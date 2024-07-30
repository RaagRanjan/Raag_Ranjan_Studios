<?php
// Start the session
session_start();

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Check if required fields are set
    if (isset($_GET['uname']) && isset($_GET['email']) && isset($_GET['upass1']) && isset($_GET['upass2']) && isset($_GET['user_type'])) {
        // Retrieve user inputs
        $uname = $_GET['uname'];
        $email = $_GET['email'];
        $upass1 = $_GET['upass1'];
        $upass2 = $_GET['upass2'];
        $user_type = $_GET['user_type'];

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format.";
            exit;
        }

        // Validate password match
        if ($upass1 !== $upass2) {
            echo "Passwords do not match.";
            exit;
        }

        // Validate name (no numbers allowed)
        if (preg_match('/[0-9]/', $uname)) {
            echo "Name cannot contain numbers.";
            exit;
        }

        // Establish connection to MySQL
        $con = mysqli_connect('localhost', 'root', '', 'rrstudios');

        // Check connection
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }

        // Escape variables for security to prevent SQL injection
        $uname = mysqli_real_escape_string($con, $uname);
        $email = mysqli_real_escape_string($con, $email);
        $upass1 = mysqli_real_escape_string($con, $upass1);
        $user_type = mysqli_real_escape_string($con, $user_type);

        // Hash the password
        $hashed_password = password_hash($upass1, PASSWORD_DEFAULT);

        // Construct the SQL query (uid column is omitted)
        $q = "INSERT INTO `userinfo` (`name`, `email`, `password`, `utype`) 
              VALUES ('$uname', '$email', '$hashed_password', '$user_type')";

        // Execute query
        if (mysqli_query($con, $q)) {
            $last_id = mysqli_insert_id($con); // Retrieve the auto-generated uid
            echo "New record inserted successfully. ID: " . $last_id;
            echo "Redirecting...";

            $delay = 3; // 3 seconds
            // Output a message
            echo "Redirecting in " . $delay . " seconds...";
            // Introduce a delay
            sleep($delay);
            // Redirect after the delay
        header("Location: ../index.html");
        
        }
        else {
            echo "Error: " . $q . "<br>" . mysqli_error($con);
        }

        // Close connection
        mysqli_close($con);
    }
    else {
        echo "Required fields are missing.";
    }
}
else {
    echo "Invalid request method.";
}
?>
