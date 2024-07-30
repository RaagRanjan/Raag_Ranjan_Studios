<?php

$email = $_POST['email'];
$upass = $_POST['upass'];

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format.";
    exit;
}

// Establish connection to MySQL
$con = mysqli_connect('localhost', 'root', '', 'rrstudios');

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Query to get user data
$q = "SELECT * FROM userinfo WHERE email = '$email'";

// Execute the query
$result = mysqli_query($con, $q);

// Check if query execution was successful
// if ($result) {
//     // Check if any rows were returned
//     if (mysqli_num_rows($result) > 0) {
//         // Fetch the data
//         $row = mysqli_fetch_assoc($result);

//         // Output the user ID (example)
//         echo "User ID: " . $row['uid'];
//     }
    
//     else {
//         echo "No user found with the provided email.";
//     }
// }

// else {
//     echo "Error: " . mysqli_error($con);
// }


if ($result) {
    // Check if any rows were returned
    if (mysqli_num_rows($result) > 0) {
        // Fetch the data
        $row = mysqli_fetch_assoc($result);

        // Output the user ID (example)
        if($row['password']==htmlspecialchars($upass)){

            echo "Login success\n";

            $delay = 3; // 3 seconds
            // Output a message
            echo "Redirecting in " . $delay . " seconds...";
            // Introduce a delay
            sleep($delay);

        }

        // Redirect after the delay
        header("Location: ../index.html");
    }
    
    else {
        echo "No user found with the provided email.";
    }
}

else {
    echo "Error: " . mysqli_error($con);
}

// Close connection
mysqli_close($con);

?>
