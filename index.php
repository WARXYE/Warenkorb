<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="container">

<h1 class="mt-5">Welcome to the Online Store</h1>

<ul class="list-group mt-3">
    <?php
    // Annahme: Die JSON-Datei befindet sich im gleichen Verzeichnis wie die PHP-Dateien
    $jsonFile = 'bookdata.php';

    if (file_exists($jsonFile)) {
        $jsonData = file_get_contents($jsonFile);
        $books = json_decode($jsonData, true);

        foreach ($books as $book) {
            // Überprüfe, ob der Schlüssel "name" vorhanden ist
            $productName = isset($book['name']) ? $book['name'] : 'N/A';

            echo '<li class="list-group-item">' . $productName . ' - $' . $book['price'] . ' <a href="cart.php?action=add&id=' . $book['id'] . '" class="btn btn-primary btn-sm float-right">Add to Cart</a></li>';
        }
    } else {
        echo '<li class="list-group-item">Error loading data</li>';
    }
    ?>
</ul>

</body>
</html>
