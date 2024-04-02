<?php
$db = new mysqli('localhost', 'root', '', 'finalproject'); // Connect to the database

$query = "SELECT * FROM products"; // SQL query to fetch all products
$result = $db->query($query);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='product'>";
        echo "<img src='" . $row['imageUrl'] . "' alt='" . $row['name'] . "'>";
        echo "<h3>" . $row['name'] . "</h3>";
        echo "<p>$" . $row['price'] . "</p>";
        // Add a "Add to Cart" button here
        echo "</div>";
    }
} else {
    echo "No products found.";
}


$db->close();
?>
