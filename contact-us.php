<?php
// Database connection setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact_us_details";  

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form values
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $message = $_POST['text_area'];

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO contact_detail (name, mobile, email, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $mobile, $email, $message);

    // Execute the query
    if ($stmt->execute()) {
        echo "Record added successfully!";
        
     
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}


$conn->close();
?>
