<?php
include "php/dbConnection.php";
include "php/book.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addToCart'])) {
    if (isset($_POST['book_id']) && isset($_POST['amount']) && $_POST['amount'] > 0) {
        $book_id = $_POST['book_id'];
        $amount = $_POST['amount'];

        $_SESSION['cart'][] = array('book_id' => $book_id, 'amount' => $amount);

        setcookie('cart_items', json_encode($_SESSION['cart']), time() + (86400 * 30), "/");
    }
}
$cartItemCount = 0;
if (isset($_SESSION['cart'])) {
    $cartItemCount = count($_SESSION['cart']);
} elseif (isset($_COOKIE['cart_items'])) {
    $_SESSION['cart'] = json_decode($_COOKIE['cart_items'], true);
    $cartItemCount = count($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop</title>
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
    </style>
</head>

<body>

<section id="shop" class="container mt-4">
    <h1 class="mb-4">Welcome to our Book Library</h1>
    <h2 class="mb-4">Our Products</h2>

    <div class="row">
        <?php
        $results = Book::getAll();
        foreach ($results as $rs) {
            echo '<div class="col-md-4">';
            echo '<div class="book-card">';
            echo '<img src="./media/image.jpg" class="book-img" alt="Book Image">';
            echo '<h3 style="font-weight: bold; margin-bottom: 5px; color: #333;">' . $rs['title'] . '</h3>';
            echo '<p style="margin-bottom: 5px; color: #555;">Price: €' . $rs['price'] . '</p>';
            echo '<p style="margin-bottom: 5px; color: #555;">Stock: ' . $rs['stock'] . '</p>';
            echo '<form method="POST" action="">';
            echo '<input type="hidden" name="book_id" value="' . $rs['id'] . '">';
            echo '<input type="number" name="amount" id="amount" style="margin-bottom: 5px; padding: 8px; border-radius: 4px; border: 1px solid #ccc; width:100%;">';
            echo '<button type="submit" name="addToCart" class="btn btn-primary black-btn" style="width: 100%;">Add to Cart</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</section>

<div id="cart-icon" onclick="location.href='php/cart.php'"><i class="fas fa-shopping-cart"></i> <?php echo $cartItemCount; ?></div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>
