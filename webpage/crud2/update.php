<?php
// Connect to the database
$conn = pg_connect("host=localhost dbname=database user=username password=password");

// Check connection
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Get POST data
$id = $_POST['id'];
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];

// Escape user inputs for security
$id = pg_escape_string($id);
$name = pg_escape_string($name);
$description = pg_escape_string($description);
$price = pg_escape_string($price);

// Update data in the database
$sql = "UPDATE items SET name='$name', description='$description', price='$price' WHERE id=$id";
$result = pg_query($conn, $sql);
if ($result) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . pg_last_error($conn);
}

// Close connection
pg_close($conn);
?>
