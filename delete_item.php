<?php
include('local.php');
if (isset($_GET['item_id'])) {
    $itemId = mysqli_real_escape_string($conn, $_GET['item_id']);
    $delete_query = "DELETE FROM menu_items WHERE item_id = '$itemId'";
    if (mysqli_query($conn, $delete_query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Missing item_id']);
}
$conn->close();
?>
