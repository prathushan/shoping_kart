<?php
include('connect.php');

// Fetch products from database
$products = mysqli_query($conn, "SELECT * FROM `products`") or die(mysqli_error($conn));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop It</title>
    <!-- CSS link -->
    <link rel="stylesheet" href="css/style.css">
    <!-- fav icons -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Internal CSS for styling -->
    <link rel="stylesheet" href="css/Shopit.css"> <!-- Include the Shopit.css -->
</head>
<body>
    <header>
        <?php include('header.php'); ?>
    </header>

    <!-- Container for displaying products -->
    <div class="container">
        <h2 class="shop_heading">Let's Shop</h2>
        <section class="product_listing">
            <?php
            if (mysqli_num_rows($products) > 0) {
                while ($row = mysqli_fetch_assoc($products)) {
                    echo "<div class='product_card'>
                        <img src='images/{$row['image']}' alt='{$row['name']}'>
                        <h3>{$row['name']}</h3>
                        <p><span class='price_label'>Price:</span> \${$row['price']}</p>
                        <a href='cart.php?id={$row['id']}' class='add_to_cart_btn'>Add to Cart</a>
                    </div>";
                }
            } else {
                echo "<p>No products available</p>";
            }
            ?>
        </section>
    </div>
</body>
</html>
