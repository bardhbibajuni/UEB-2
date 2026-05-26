<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'brain_boost');
define('DB_USER', 'root');       
define('DB_PASS', '');          
define('DB_CHARSET', 'utf8mb4');

function getDB(): PDO {
    static $pdo = null;

    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            error_log('DB Connection failed: ' . $e->getMessage());
            die('<div style="font-family:sans-serif;padding:40px;color:#f87171;background:#0b0f19;">
                 <h2>Database connection failed.</h2>
                 <p>Please make sure MySQL is running and <code>db.php</code> credentials are correct.</p>
                 </div>');
        }
    }

    return $pdo;
}
