<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "bandarajaya";
$port = 3307;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = file_get_contents(__DIR__ . '/migration_penerbangan.sql');

if ($conn->multi_query($sql) === TRUE) {
  echo "Migration executed successfully\n";
  // Consume all results
  while ($conn->more_results() && $conn->next_result()) {
    $result = $conn->use_result();
    if ($result instanceof mysqli_result) {
        $result->free();
    }
  }
} else {
  echo "Error executing migration: " . $conn->error . "\n";
}

$conn->close();
?>
