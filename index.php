<?php
include('connect.php');

$display_message = ''; // Initialize display message variable

if (isset($_POST['add_product'])) {
    $product_name = mysqli($conn, $_POST['product_name']);
    $product_price = mysqli($conn, $_POST['product_price']);
    $product_image = $_FILES['product_image']['name'];
    $product_image_temp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'images/' . $product_image;

    // Insert product into database
    $insert_query = mysqli_query($conn, "INSERT INTO `products` (name, price, image) VALUES ('$product_name', '$product_price', '$product_image')");

    if ($insert_query) {
        move_uploaded_file($product_image_temp_name, $product_image_folder);
        $display_message = "Product inserted successfully";
    } else {
        $display_message = "Error occurred in inserting product: " . mysqli_error($conn);
    }
}

// Fetch products from database
$products = mysqli_query($conn, "SELECT * FROM `products`") or die(mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Kart</title>
    <!-- CSS link -->
    <link rel="stylesheet" href="css/style.css">
    <!-- fav icons -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- Header -->
    <?php include('header.php'); ?>

    <!-- Form Section -->
    <div class="container">
        <?php if (!empty($display_message)): ?>
            <div class='display_message'>
                <span><?php echo $display_message; ?></span>
                <i class='fas fa-times' onclick='this.parentElement.style.display="none"'></i>
            </div>
        <?php endif; ?>

        <section>
            <h3 class="heading">Add Products</h3>
            <form action="" class="add_products" method="post" enctype="multipart/form-data">
                <input type="text" name="product_name" placeholder="Enter Product name" class="input_fields" required>
                <input type="number" name="product_price" min="0" placeholder="Enter Product Price" class="input_fields" required>
                <input type="file" name="product_image" class="input_fields" required accept="image/png, image/jpg, image/jpeg">
                <input type="submit" name="add_product" class="submit_btn" value="Add Product">
            </form>
        </section>
    </div>

    <!-- JavaScript Link (for example purposes) -->
    <script src="js/script.js"></script>
</body>
</html>
