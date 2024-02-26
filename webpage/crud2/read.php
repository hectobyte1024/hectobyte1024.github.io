<?php
// Connect to the database
$conn = pg_connect("host=localhost dbname=database user=username password=password");

// Check connection
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Select data from the database
$sql = "SELECT * FROM items";
$result = pg_query($conn, $sql);

// Display data
if (pg_num_rows($result) > 0) {
    while ($row = pg_fetch_assoc($result)) {
        echo "ID: " . $row['id'] . " - Name: " . $row['name'] . " - Description: " . $row['description'] . " - Price: " . $row['price'] . "<br>";
    }
} else {
    echo "0 results";
}

// Close connection
pg_close($conn);
?>

