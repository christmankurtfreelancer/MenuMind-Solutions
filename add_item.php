<?php
include('local.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = nl2br(trim($_POST['description']));
    $category = $_POST['category'];
    $price = isset($_POST['price']) ? $_POST['price'] : null;
    
    if ($price === '') {
        $price = null;
    }

    $target_dir = "uploads/";
    $target_file = $target_dir . (isset($_FILES["item_image"]["name"]) ? basename($_FILES["item_image"]["name"]) : '');

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (isset($_FILES["item_image"]) && $_FILES["item_image"]["error"] == UPLOAD_ERR_OK) {
        if (isset($_FILES["item_image"]["tmp_name"])) {
            if (move_uploaded_file($_FILES["item_image"]["tmp_name"], $target_file)) {
                echo "The file " . basename($_FILES["item_image"]["name"]) . " has been uploaded.<br>";
            } else {
                echo "Sorry, there was an error uploading your file.<br>";
            }
        }
    }

    $stmt = $conn->prepare("INSERT INTO menu_items (name, description, category, price, item_image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $description, $category, $price, $target_file);

    if ($stmt->execute()) {
        echo "Item added successfully!<br>";
        header("Location: index.php");
    } else {
        echo "Error adding item: " . $stmt->error . "<br>";
    }

    $stmt->close();
}

$conn->close();
?>
