

<?php
    $host = 'localhost';
    $dbname = 'ffx_impact';
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $uri = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        switch ($uri) {
            case 'characters':
                include 'api/characters.php';
                break;
            case 'characterDetails':
                include 'api/characterDetails.php';
                break;
            case 'overdriveDetails':
                include 'api/overdriveDetails.php';
                break;
            default:
                http_response_code(404);
                echo json_encode(['error' => 'Route not found']);
                break;
        }

    } catch(PDOexception $e){
        die("Database connection failed: " . $e->getMessage());
    }
?>