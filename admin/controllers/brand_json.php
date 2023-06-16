<?php
session_start();
if (!isset($_SESSION["username"])) {
    header('Location: ../404.php');
    exit;
}

require 'includes/dbConnection.php';

if (isset($_POST['updateProfile'])) {
    $brandId = $_POST['brandId'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $facebook = $_POST['facebook'];
    $image = $_POST['oldImage']; // Added this line to store the old image value

    // Check if a new image file was uploaded
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $newImage = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];

        // Move the uploaded image to a folder
        $upload_directory = "./upload/";
        $uploaded_image = $upload_directory . basename($newImage);
        move_uploaded_file($tmp_name, $uploaded_image);

        $image = $newImage; // Set the image variable to the new image value
    }

    try {
        $sql = "UPDATE Brand SET name = :name, phone = :phone, address = :address, email = :email, facebook = :facebook, image = :image WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':facebook', $facebook);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':id', $brandId);
        $stmt->execute();

        // Optional: Show a success message or redirect to another page
        echo "Profile updated successfully!";
    } catch (PDOException $e) {
        // Handle any database errors
        echo "Update failed: " . $e->getMessage();
    }
}
?>