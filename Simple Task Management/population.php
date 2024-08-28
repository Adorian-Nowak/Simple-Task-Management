<?php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Drop tables if they already exist
$conn->query("DROP TABLE IF EXISTS tasks");
$conn->query("DROP TABLE IF EXISTS users");
$conn->query("DROP TABLE IF EXISTS status");

// Create tables
$sql = "
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);
";
if ($conn->query($sql) === TRUE) {
    echo "Table 'users' created successfully.<br>";
} else {
    echo "Error creating 'users' table: " . $conn->error . "<br>";
}

$sql = "
CREATE TABLE status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);
";
if ($conn->query($sql) === TRUE) {
    echo "Table 'status' created successfully.<br>";
} else {
    echo "Error creating 'status' table: " . $conn->error . "<br>";
}

$sql = "
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    user_id INT,
    assigned_user_id INT,
    status_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (assigned_user_id) REFERENCES users(id),
    FOREIGN KEY (status_id) REFERENCES status(id)
);
";
if ($conn->query($sql) === TRUE) {
    echo "Table 'tasks' created successfully.<br>";
} else {
    echo "Error creating 'tasks' table: " . $conn->error . "<br>";
}

// Sample data for users
$users = [
    'admin',
    'user1',
    'user2'
];

// Sample data for status
$statuses = [
    'Planned',
    'In progress',
    'Complete',
    'Cancelled'
];

// Insert sample data into `users` table
foreach ($users as $user) {
    $sql = "INSERT INTO users (name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
}

// Insert sample data into `status` table
foreach ($statuses as $status) {
    $sql = "INSERT INTO status (name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $status);
    $stmt->execute();
}

// Get IDs of the inserted users and statuses
$user_ids = [];
$status_ids = [];

$result = $conn->query("SELECT id FROM users");
while ($row = $result->fetch_assoc()) {
    $user_ids[] = $row['id'];
}

$result = $conn->query("SELECT id FROM status");
while ($row = $result->fetch_assoc()) {
    $status_ids[] = $row['id'];
}

// Sample data for tasks
$tasks = [
    ['Task 1', $user_ids[0], $user_ids[1], $status_ids[0]],
    ['Task 2', $user_ids[1], $user_ids[2], $status_ids[1]],
    ['Task 3', $user_ids[2], $user_ids[0], $status_ids[2]],
    ['Task 4', $user_ids[0], $user_ids[1], $status_ids[3]]
];

// Insert sample data into `tasks` table
foreach ($tasks as $task) {
    $sql = "INSERT INTO tasks (name, user_id, assigned_user_id, status_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siii", $task[0], $task[1], $task[2], $task[3]);
    $stmt->execute();
}

// Close connection
$conn->close();

echo "Database populated successfully.";

header("Location: ./index");

?>
