<?php 
include('connect.php');

if(isset($_GET['id'])){
    $delete_id = $_GET['id'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("DELETE FROM `products` WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $result = $stmt->execute();

    if ($result) {
        // Redirect to the view products page after successful deletion
        header("Location: view_products.php");
        exit();
    } else {
        echo "Failed to delete the product";
    }
}
?>
