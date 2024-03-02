<?php
// Ensure that the content type is JSON
header('Content-Type: application/json');

// Include the database configuration
require_once './connection.php';

// Handle HTTP methods
$method = $_SERVER['REQUEST_METHOD'];

class characterClass {
    public $id;
    public $name;
    public function __construct($id, $name){
        $this->id = $id;
        $this->name = $name;
    }
}

    try {
        $stmt = $pdo->prepare('SELECT `name`,id FROM `character`');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $characters = [];

        foreach ($result as $row) {
            // Create a new characterClass object for each row of data
            $character = new characterClass($row['id'], $row['name']);
            $characters[] = $character;
        }
        echo json_encode($characters);
        
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch characters: ' . $e->getMessage()]);
    }

?>