<?php
// Create connection
$conn = new mysqli('localhost', 'root', '', 'school_career');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $vacancy = $_POST['vacancy'];
    $subject = $_POST['subject'];

    // Handle file upload
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
        $resume = $_FILES['resume']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($resume);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Move uploaded file to the target directory
            if (move_uploaded_file($_FILES['resume']['tmp_name'], $target_file)) {
                // Prepare and bind
                $stmt = $conn->prepare("INSERT INTO applications (name, mobile, email, gender, vacancy, subject, resume) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssss", $name, $mobile, $email, $gender, $vacancy, $subject, $target_file);

                // Execute the query
                if ($stmt->execute()) {
                    echo "Uploaded Successfully!";
                } else {
                    echo "Oops! Something went wrong: " . $stmt->error;
                }

                // Close statement
                $stmt->close();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "No file was uploaded or there was an upload error: " . $_FILES['resume']['error'];
    }


// Close connection
$conn->close();
?>
