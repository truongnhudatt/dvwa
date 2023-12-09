<?php
include_once "config.php";
include_once "variable.php";
global $conn;

function executeStatement($conn, $sql, $successMessage) {
    $stmt = $conn->prepare($sql);
    if ($stmt->execute() === TRUE) {
    } else {
        die("Error executing statement" . $stmt->error);
    }
}

function createDatabase($conn, $databaseName) {
    $sqlCreateDb = "CREATE DATABASE IF NOT EXISTS $databaseName";
    executeStatement($conn, $sqlCreateDb, "Database '$databaseName' has been created successfully.");

    $conn->query("USE $databaseName");

    createTables($conn);
    insertSampleData($conn);
    $conn->close();
}

function createTables($conn) {
    $sqlCreateTableUsers = "CREATE TABLE IF NOT EXISTS users (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            first_name VARCHAR(255) NOT NULL,
                            last_name VARCHAR(255) NOT NULL,
                            email VARCHAR(255) NOT NULL UNIQUE,
                            username VARCHAR(255) NOT NULL UNIQUE,
                            password VARCHAR(255) NOT NULL)";
    $sqlCreateTableLoginAttempts = "CREATE TABLE IF NOT EXISTS login_attempts (
                                            id INT AUTO_INCREMENT PRIMARY KEY,
                                            ip_address VARCHAR(50) NOT NULL,
                                            attempts INT NOT NULL DEFAULT 0,
                                            last_attempt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                            expire_time DATETIME
                                        )";
    executeStatement($conn, $sqlCreateTableUsers, "Table 'users' has been created successfully.");
    executeStatement($conn, $sqlCreateTableLoginAttempts, "login_attempts 'users' has been created successfully.");

}
function insertSampleData($conn) {
    $sqlInsertData = "INSERT INTO users (first_name, last_name, email, username, password) VALUES
                      ('Admin', 'Admin', 'admin@truongnhudat.it', 'ptit', '".password_hash('ptit@123', PASSWORD_DEFAULT)."'),
                      ('User', 'User', 'user@truongnhudat.it', 'ptit1', '".password_hash('ptit@123', PASSWORD_DEFAULT)."'),
                      ('Đạt', 'Trương', 'tnd@truongnhudat.it', 'ptit2', '".password_hash('ptit@123', PASSWORD_DEFAULT)."')";
    executeStatement($conn, $sqlInsertData, "Table 'users' has been inserted sample data successfully.");
}
$result = $conn->query("SHOW DATABASES LIKE '$db_name'");
if ($result->num_rows == 0) {
    createDatabase($conn, $db_name);
}
?>