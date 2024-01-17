<?php
session_start();

include "dbConnection.php";
include "book.php";

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : (isset($_COOKIE['cart_items']) ? json_decode($_COOKIE['cart_items'], true) : array());
$errorMessages = array();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmOrder'])) {

    foreach ($cart as $item) {
        $bookDetails = Book::getBookDetails($item['book_id']);
        $newStock = $bookDetails['stock'] - $item['amount'];

        if ($newStock < 0) {
            $errorMessages[] = 'Insufficient stock for ' . $bookDetails['title'];
        }
    }

    if (empty($errorMessages)) {
        foreach ($cart as $item) {
            $bookDetails = Book::getBookDetails($item['book_id']);
            $newStock = $bookDetails['stock'] - $item['amount'];

            $sql = "UPDATE bookdata SET stock = :newStock WHERE id = :bookId";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':newStock', $newStock, PDO::PARAM_INT);
            $stmt->bindParam(':bookId', $item['book_id'], PDO::PARAM_INT);
            $stmt->execute();
        }

        $_SESSION['cart'] = array();
        setcookie('cart_items', '', time() - 3600, '/');

        header('Location: orderConfirmation.php');
        exit();
    } else {
        echo '<div class="alert alert-warning" role="alert">';
        echo 'The order quantity is greater than the available stock. You will be redirected to the cart page.';
        echo '</div>';
        header('refresh:4;url=cart.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
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

<section id="checkout" class="container mt-4">
    <h1 class="mb-4">Checkout</h1>
    <p>Please review your order</p>

    <?php
    if (!empty($errorMessages)) {
        echo '<div class="alert alert-danger" role="alert">';
        foreach ($errorMessages as $errorMessage) {
            echo '<p>' . $errorMessage . '</p>';
        }
        echo '</div>';
    } else {

        foreach ($cart as $productId => $item) {
            $bookDetails = Book::getBookDetails($item['book_id']);

            echo '<div style="border: 1px solid #ccc; border-radius: 8px; padding: 1rem; margin-bottom: 1rem; display: flex; align-items: center;">';
            echo '<img src="../media/image.jpg" style="width: 80px; height: auto; margin-right: 20px; border-radius: 4px; object-fit: cover;">'; // Adjust the path here
            echo '<div>';
            echo '<h3>' . $bookDetails['title'] . '</h3>';
            echo '<p>Quantity: ' . $item['amount'] . '</p>';
            echo '<p>Price per unit: €' . $bookDetails['price'] . '</p>';
            echo '<p>Total Price: €' . ($item['amount'] * $bookDetails['price']) . '</p>';
            echo '</div>';
            echo '</div>';
        }

        echo '<form method="POST" action="checkout.php">';
        echo '<button type="submit" name="confirmOrder" class="btn btn-success black-btn">Complete Order</button>';
        echo '</form>';
    }
    ?>

</section>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>