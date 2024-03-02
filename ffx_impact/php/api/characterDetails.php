<?php
// Ensure that the content type is JSON
header('Content-Type: application/json');

// Include the database configuration
require_once './connection.php';

// Handle HTTP methods
$method = $_SERVER['REQUEST_METHOD'];

class CharacterDetailsClass {
    public $idCharacter;
    public $name;
    public $sphereGrid;
    public $description;
    public $formation;
    public $idOverdrive;
    public $overdrive;
    public $overdriveItems;

    // Constructor to initialize the object with data
    public function __construct($id, $name, $sphere_grid, $description, $formation, $overdrive_id, $overdrive, $overdriveItems) {
        $this->idCharacter = $id;
        $this->name = $name;
        $this->sphereGrid = $sphere_grid;
        $this->description = $description;
        $this->formation = $formation;
        $this->idOverdrive = $overdrive_id;
        $this->overdrive = $overdrive;
        $this->overdriveItems = $overdriveItems;
    }
}

// Get the value of the 'id' query parameter, if it exists
$id = isset($_GET['id']) ? $_GET['id'] : null;

try {
    $characters = []; // Initialize the array

    if ($id !== null) {
        // If 'id' parameter is provided, fetch character with that id
        $stmtCharacter = $pdo->prepare('SELECT `character`.*, overdrive.overdrive_name AS overdrive
        FROM `character`
        LEFT JOIN overdrive ON `character`.overdrive_id = overdrive.overdrive_id 
        WHERE `character`.id = :id');
 
        $stmtCharacter->execute(['id' => $id]);
    } else {
        // If 'id' parameter is not provided, fetch all characters
        $stmtCharacter = $pdo->query('SELECT * FROM `character`');
    }
    $characterData = $stmtCharacter->fetchAll(PDO::FETCH_ASSOC);

    foreach ($characterData as $row) {
        $overdrive_id = $row['overdrive_id'];

        $stmtOverdriveItems = $pdo->prepare('SELECT sub_drive_name AS `name`, Sub_drive_id AS id, sub_drive_img as `image` FROM sub_drive WHERE overdrive_id = :overdrive_id');
        $stmtOverdriveItems->execute(['overdrive_id' => $overdrive_id]);
        $overdriveItemsData = $stmtOverdriveItems->fetchAll(PDO::FETCH_ASSOC);

        $character = new CharacterDetailsClass(
            $row['id'],
            $row['name'], 
            $row['sphere_grid'], 
            $row['description'], 
            $row['formation'], 
            $row['overdrive_id'], 
            $row['overdrive'],
            $overdriveItemsData // Pass overdrive items data directly
        );
        $characters[] = $character;
    }

    echo json_encode($characters);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch character: ' . $e->getMessage()]);
}
?>
