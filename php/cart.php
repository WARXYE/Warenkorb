<?php
session_start();

include "dbConnection.php";
include "book.php";

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['removeFromCart'])) {
    $productIdToRemove = $_POST['removeFromCart'];

    if (isset($cart[$productIdToRemove])) {
        unset($cart[$productIdToRemove]);
        $_SESSION['cart'] = array_values($cart);

        setcookie('cart_items', json_encode($_SESSION['cart']), time() + (86400 * 30), "/");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateQuantity'])) {
    $ProductIdToUpdate = $_POST['updateQuantity'];
    $newQuantity = $_POST['quantity'];

    if (isset($cart[$ProductIdToUpdate])) {
        $cart[$ProductIdToUpdate]['amount'] = $newQuantity;
        $_SESSION['cart'] = $cart;

        setcookie('cart_items', json_encode($_SESSION['cart']), time() + (86400 * 30), "/");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        #cart-icon {
            position: fixed;
            top: 30px;
            right: 30px;
            cursor: pointer;
        }

        .book-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 20px;
        }

        .book-img {
            width: 80px;
            height: auto;
            margin-right: 20px;
            border-radius: 4px;
            object-fit: cover;
        }

        .black-btn {
            background-color: black;
            color: white;
            border: none;
        }

        .black-btn:hover {
            background-color: black;
            color: white;
        }
    </style>
</head>

<body>

<section id="cart" class="container mt-4">
    <h1 class="mb-4">Shopping Cart</h1>

    <?php
    if (empty($cart)) {
        echo '<p>Your shopping cart is empty.</p>';
    } else {
        foreach ($cart as $productId => $item) {
            $bookDetails = Book::getBookDetails($item['book_id']);

            echo '<div class="border p-3 mb-3">';
            echo '<img src="../media/image.jpg" class="mr-3" style="width: 80px; height: auto; border-radius: 4px; object-fit: cover;">';
            echo '<div>';
            echo '<h3>' . $bookDetails['title'] . '</h3>';
            echo '<form method="POST" action="cart.php">';
            echo '<p>Quantity: <input type="number" name="quantity" value="' . $item['amount'] . '" min="1" style="border: none;"></p>';
            echo '<input type="hidden" name="updateQuantity" value="' . $productId . '">';
            echo '<button type="submit" class="btn btn-secondary black-btn" style="display:none;">Update</button>';
            echo '</form>';
            echo '<p>Price per unit: €' . $bookDetails['price'] . '</p>';
            echo '<p>Total Price: €' . ($item['amount'] * $bookDetails['price']) . '</p>';
            echo '<form method="POST" action="cart.php">';
            echo '<input type="hidden" name="removeFromCart" value="' . $productId . '">';
            echo '<button type="submit" class="btn btn-danger black-btn">Remove</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
        }

        $totalPrice = array_sum(array_map(function ($item) {
            $bookDetails = Book::getBookDetails($item['book_id']);
            return $item['amount'] * $bookDetails['price'];
        }, $cart));

        echo '<h4>Total: €' . $totalPrice . '</h4>';

        echo '<form method="POST" action="checkout.php">';
        echo '<button type="submit" class="btn btn-success black-btn">Proceed to Checkout</button>';
        echo '</form>';
    }

    echo '<form method="GET" action="../index.php" class="mt-4">';
    echo '<button type="submit" class="btn btn-primary black-btn">Back to Homepage</button>';
    echo '</form>';
    ?>
</section>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>
