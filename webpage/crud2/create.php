<?php
// Connect to the database
$conn = pg_connect("host=localhost dbname=database user=username password=password");

// Check connection
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Get POST data
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];

// Escape user inputs for security
$name = pg_escape_string($name);
$description = pg_escape_string($description);
$price = pg_escape_string($price);

// Insert data into the database
$sql = "INSERT INTO items (name, description, price) VALUES ('$name', '$description', '$price')";
$result = pg_query($conn, $sql);
if ($result) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . pg_last_error($conn);
}

// Close connection
pg_close($conn);
?>

