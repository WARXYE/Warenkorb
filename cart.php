<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $productID = intval($_GET['id']);

    if (!in_array($productID, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $productID;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="container">

<h1 class="mt-5">Shopping Cart</h1>

<?php if (!empty($_SESSION['cart'])): ?>
    <ul class="list-group mt-3">
        <?php foreach ($_SESSION['cart'] as $productID): ?>
            <li class="list-group-item">
                Product <?php echo $productID; ?> - $<?php echo rand(10, 50); ?>
                <a href="cart.php?action=remove&id=<?php echo $productID; ?>" class="btn btn-danger btn-sm float-right">Remove</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p class="mt-3">Your shopping cart is empty.</p>
<?php endif; ?>

<a href="index.php" class="btn btn-primary mt-3">Continue Shopping</a>

</body>
</html>