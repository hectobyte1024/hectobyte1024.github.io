<?php
// Connect to the database
$conn = pg_connect("host=localhost dbname=database user=username password=password");

// Check connection
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Get POST data
$id = $_POST['id'];

// Escape user inputs for security
$id = pg_escape_string($id);

// Delete data from the database
$sql = "DELETE FROM items WHERE id=$id";
$result = pg_query($conn, $sql);
if ($result) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . pg_last_error($conn);
}

// Close connection
pg_close($conn);
?>
