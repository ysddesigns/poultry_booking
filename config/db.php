<?php
declare(strict_types=1);

/**
 * Database Connection
 * 
 * Returns a PDO instance for database interaction.
 *
 * @return PDO
 * @throws PDOException
 */
function getDBConnection(): PDO
{
    // Configuration - In a real app, use env vars
    $host = 'localhost';
    $dbname = 'poultry_booking';
    $username = 'root';
    $password = ''; // Default XAMPP password
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        return new PDO($dsn, $username, $password, $options);
    } catch (PDOException $e) {
        // Log error and throw generic exception to avoid leaking credentials
        error_log($e->getMessage());
        throw new PDOException('Database connection failed. Please check logs.');
    }
}
