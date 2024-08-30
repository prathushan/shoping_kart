<?php
session_start();
include('connect.php');

// Initialize cart in session if not already
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Add product to cart
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch product details from the database
    $result = mysqli_query($conn, "SELECT * FROM `products` WHERE id = {$product_id}");
    if (mysqli_num_rows($result) == 1) {
        $product = mysqli_fetch_assoc($result);
        
        // Check if the product is already in the cart
        if (!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = array(
                "name" => $product['name'],
                "price" => $product['price'],
                "image" => $product['image'],
                "quantity" => 1
            );
        } else {
            // If product is already in cart, increase the quantity
            $_SESSION['cart'][$product_id]['quantity']++;
        }
    }
    // Redirect to prevent form resubmission on refresh
    header("Location: cart.php");
    exit;
}

// Remove product from cart
if (isset($_GET['remove']) && isset($_SESSION['cart'][$_GET['remove']])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    // Redirect to prevent form resubmission on refresh
    header("Location: cart.php");
    exit;
}

// Update product quantity in cart
if (isset($_GET['id']) && isset($_GET['quantity'])) {
    $product_id = $_GET['id'];
    $new_quantity = intval($_GET['quantity']);

    // Validate new quantity
    if ($new_quantity > 0) {
        $_SESSION['cart'][$product_id]['quantity'] = $new_quantity;
    } else {
        // If quantity is zero or less, remove the item from cart
        unset($_SESSION['cart'][$product_id]);
    }

    // Redirect to prevent form resubmission on refresh
    header("Location: cart.php");
    exit;
}

// Calculate total price
$total_price = 0;
foreach ($_SESSION['cart'] as $id => $product) {
    $total_price += $product['price'] * $product['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .cart_table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .cart_table th, .cart_table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
            color:black;
        }
        .total_price {
            margin-top: 10px;
            font-size: 18px;
            float: left; /* Aligns total price to the left */
        }
        .checkout_wrapper {
            overflow: hidden; /* Clear floats */
            margin-top: 20px;
        }
        .checkout_btn, .grand_total_btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
            margin-top: 10px;
            float: right; /* Aligns buttons to the right */
        }
        .grand_total_btn {
            margin-right: 10px; /* Adds space between buttons */
        }
        .remove_link {
            color: red;
        }
        .quantity_controls {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .quantity_controls button {
            padding: 5px 10px;
            margin: 0 5px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            outline: none;
        }
    </style>
</head>
<body>
    <header>
        <?php include('header.php'); ?>
    </header>

    <div class="container">
        <h2 class="cart_heading">Your Shopping Cart</h2>
        <?php if (!empty($_SESSION['cart'])): ?>
            <table class="cart_table">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Product Image</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $counter = 1;
                    foreach ($_SESSION['cart'] as $id => $product): 
                        $product_total = $product['price'] * $product['quantity'];
                    ?>
                        <tr>
                            <td><?php echo $counter++; ?></td>
                            <td><img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" style="width: 50px;"></td>
                            <td><?php echo $product['name']; ?></td>
                            <td>$<?php echo $product['price']; ?></td>
                            <td>
                                <div class="quantity_controls">
                                    <button class="quantity_dec" data-id="<?php echo $id; ?>">-</button>
                                    <input type="number" min="0" class="quantity_input" value="<?php echo $product['quantity']; ?>" data-id="<?php echo $id; ?>">
                                    <button class="quantity_inc" data-id="<?php echo $id; ?>">+</button>
                                </div>
                                <!-- Hidden input to store product ID -->
                                <input type="hidden" class="product_id_input" value="<?php echo $id; ?>">
                            </td>
                            <td>$<?php echo $product_total; ?></td>
                            <td>
                                <a href="?remove=<?php echo $id; ?>" class="remove_link"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="checkout_wrapper">
                <p class="total_price"><strong>Total Price: $<?php echo $total_price; ?></strong></p>
                <a href="checkout.php" class="checkout_btn">Proceed to Checkout</a>
                <a href="#" class="grand_total_btn">Grand Total: $<?php echo $total_price; ?></a>
            </div>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-n97wHKZ40Q47pRJY9esu6ur+6Gzae3eZffN4G3wGWz4laLjxzxZb5UFXANwW+M96hCUgT/+ZtFqzKml+O8sNlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener for plus (+) button
            var plusButtons = document.querySelectorAll('.quantity_controls .quantity_inc');
            plusButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var productId = this.getAttribute('data-id');
                    updateQuantity(productId, 'inc');
                });
            });

            // Event listener for minus (-) button
            var minusButtons = document.querySelectorAll('.quantity_controls .quantity_dec');
            minusButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var productId = this.getAttribute('data-id');
                    updateQuantity(productId, 'dec');
                });
            });

            function updateQuantity(productId, action) {
                var currentQuantity = parseInt(document.querySelector('.quantity_input[data-id="' + productId + '"]').value);
                var newQuantity;

                if (action === 'inc') {
                    newQuantity = currentQuantity + 1;
                } else if (action === 'dec') {
                    newQuantity = currentQuantity - 1 >= 0 ? currentQuantity - 1 : 0;
                }

                // Update quantity in session cart via AJAX or redirect
                var url = 'cart.php?id=' + productId + '&quantity=' + newQuantity;

                // Use fetch API to make the AJAX request
                fetch(url, {
                method: 'GET',
            })
            .then(response => {
                    if (response.ok) {
                        return response.text();
                    }
                    throw new Error('Network response was not ok.');
                })
                .then(data => {
                    // Update the quantity input field in the cart table
                    document.querySelector('.quantity_input[data-id="' + productId + '"]').value = newQuantity;

                    // Calculate new total for the current product
                    var updatedProductTotal = parseFloat(data);
                    var productTotalElement = document.querySelector('td[data-product-id="' + productId + '"] .product_total');
                    productTotalElement.textContent = '$' + updatedProductTotal.toFixed(2);

                    // Calculate and update the total price in the cart
                    var total_price = 0;
                    document.querySelectorAll('.product_total').forEach(function(element) {
                        total_price += parseFloat(element.textContent.slice(1)); // Remove '$' and convert to float
                    });
                    document.querySelector('.total_price strong').textContent = '$' + total_price.toFixed(2);
                })
                .catch(error => {
                    console.error('Error updating quantity:', error);
                });
            }
        });
    </script>
</body>
</html>


