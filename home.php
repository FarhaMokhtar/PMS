<?php
require_once 'config.php';
require_once 'user.php';
require_once 'Product.php';

session_start();

$users = $user->getAllUsers();
// if (!isset($_SESSION['loggedin']) || !isset($_SESSION['role'])) {
//     header('Location: login.php');
//     exit();
// }

$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Management System</title>
</head>
<body>
    <h1>Product Management System</h1>

    <?php 
    //display products for users
    // if($users['role']=="user"){
    //     $products = $product->getAllProducts();
    //     if (!empty($products)) {
    //         echo '<h2>Products</h2>';
    //         echo '<ul>';
    //         foreach ($products as $product) {
    //             echo '<li>';
    //             echo '<strong>Name:</strong> ' . $product['name'] . '<br>';
    //             echo '<strong>Price:</strong> $' . $product['price'] . '<br>';
    //             echo '<strong>Description:</strong> ' . $product['description'] . '<br>';
    //             echo '<strong>Stock:</strong> ' . $product['stock'] . '<br>';
    //             echo '</li>';
    //         }
    //         echo '</ul>';
    //     }
    // }else
    if ('admin') {
          // Delete or update products
          $products = $product->getAllProducts();
          if (!empty($products)) {
              echo '<h2>Admin Actions</h2>';
              echo '<ul>';
              foreach ($products as $product) {
                  echo '<li>';
                  echo '<strong>Name:</strong> ' . $product['name'] . '<br>';
                  echo '<strong>Price:</strong> $' . $product['price'] . '<br>';
                  echo '<strong>Description:</strong> ' . $product['description'] . '<br>';
                  echo '<strong>Stock:</strong> ' . $product['stock'] . '<br>';
                  echo '<a href="delete_product.php?id=' . $product['id'] . '">Delete</a> ';
                  echo '<a href="update_product.php?id=' . $product['id'] . '">Update</a>';
                  echo '</li>';
              }
              echo '</ul>';
          }
    }
    ?>
</body>
</html>