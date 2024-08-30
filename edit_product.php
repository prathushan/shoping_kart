<?php
include('connect.php');

// Initialize variables
$product_name = '';
$product_price = '';
$product_image = '';

// Check if product ID is provided in URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch product details from database
    $result = mysqli_query($conn, "SELECT * FROM `products` WHERE id = {$product_id}");
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $product_name = $row['name'];
        $product_price = $row['price'];
        $product_image = $row['image'];
    } else {
        echo "Product not found.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <!-- Internal CSS for styling -->
    <link rel="stylesheet" href="css/style.css">
    <!-- fav icons -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .edit_product {
            text-align: center;
            margin-bottom: 20px;
            width: 600px;
        }

        .edit_product h2 {
            margin-bottom: 20px;
            color: #333; /* Color for h2 tag */
        }

        .edit_product label {
            font-weight: bold;
            margin-bottom: 10px;
            color: black; /* Color for label text */
          
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: left;
        }

        form input[type="text"],
        form input[type="number"],
        form input[type="file"] {
            padding: 8px;
            margin-bottom: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        form input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 3px;
            font-size: 16px;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <header> 
        <?php include('header.php'); ?>
    </header>

    <!-- Container for editing product -->
    <div class="container">
        <section class="edit_product">
            <h2>Edit Product</h2>
            <form action="update_product.php?id=<?php echo $product_id; ?>" method="post" enctype="multipart/form-data">
                <label for="product_name" >Product Name:</label>
                <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>" required>
                <br><br>
                <label for="product_price">Product Price:</label>
                <input type="number" id="product_price" name="product_price" value="<?php echo $product_price; ?>" min="0" required>
                <br><br>
                <label for="product_image">Product Image:</label>
                <input type="file" id="product_image" name="product_image" accept="image/png, image/jpg, image/jpeg">
                <br><br>
                <img src="images/<?php echo $product_image; ?>" alt="<?php echo $product_name; ?>" width="200" height="100">
                <br><br>
                <input type="submit" name="update_product" value="Update Product">
            </form>
        </section>
    </div>
</body>
</html>
