<?php include('connect.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <!-- CSS link -->
    <link rel="stylesheet" href="css/style.css">
    <!-- fav icons -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header> 
       <?php include('header.php'); ?>
    </header>

    <!-- Container  -->
    <div class="container">
        <section class="display_product">
           <table>
               <thead>
                     <tr>
                         <th>Sl No</th>
                         <th>Product Image</th>
                         <th>Product Name</th>
                         <th>Product Price</th>
                         <th>Action</th>
                     </tr>
               </thead>
               <tbody>
                  <!-- PHP code for fetching from DB -->
                  <?php  
                    $display_product = mysqli_query($conn, "SELECT * FROM `products`") or die(mysqli_error($conn));
                    if(mysqli_num_rows($display_product) > 0) {
                        $sl_no = 1;
                        while ($row = mysqli_fetch_assoc($display_product)) {
                            echo "<tr>
                                <td>{$sl_no}</td>
                                <td><img src='images/{$row['image']}' alt='{$row['name']}' width='200' height='100'></td>
                                <td>{$row['name']}</td>
                                <td>{$row['price']}</td>
                                <td>
                                    <a href='delete_product.php?id={$row['id']}' class='delete_product_btn' onclick='return confirm(\"Are you sure you want to delete this product?\");'><i class='fas fa-trash'></i></a>
                                 
                                    <a href='edit_product.php?id={$row['id']}' class='edit_product_btn' onclick='editProduct({$row['id']})'><i class='fas fa-edit'></i>></a>
     
                                  
                                </td
                            </tr>";
                            $sl_no++;
                        }
                    } else {
                        echo "<tr><td colspan='5'>No products found</td></tr>";
                    }
                  ?>
               </tbody>
            </table>
        </section>
    </div> 

    <!-- JavaScript to handle edit action -->
    <script>
        function editProduct(productId) {
            // Redirect to edit_product.php with product ID
            window.location.href = `edit_product.php?id=${productId}`;
        }
    </script>
</body>
</html>
