<?php
// Ensure that the content type is JSON
header('Content-Type: application/json');

// Include the database configuration
require_once './connection.php';

// Handle HTTP methods
$method = $_SERVER['REQUEST_METHOD'];

class subdriveClass {
    public $idSubdrive;
    public $name;
    public $description;
    public $aditionalDescription;
    public $target;
    public $requirement;
    public $image;

    public function __construct($sub_drive_id, $sub_drive_name, $sub_drive_description, $sub_drive_aditional_desc, $sub_drive_target, $sub_drive_requirement, $sub_drive_img) {
        $this->idSubdrive = $sub_drive_id;
        $this->name = $sub_drive_name;
        $this->description = $sub_drive_description;
        $this->aditionalDescription = $sub_drive_aditional_desc;
        $this->target = $sub_drive_target;
        $this->requirement = $sub_drive_requirement;
        $this->image = $sub_drive_img;
    }
}

    $id = isset($_GET['id']) ? $_GET['id'] : null;

    try {
        if ($id !== null) {
            $stmt = $pdo->prepare('SELECT * FROM `sub_drive` WHERE `sub_drive_id` = :id');
            $stmt->execute(['id' => $id]);
        } else {
            $stmt = $pdo->query('SELECT * FROM `character`');
        }

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $subDrives = [];
        foreach ($result as $row) {
            $subDrive = new subdriveClass(
                $row['sub_drive_id'],
                $row['sub_drive_name'],
                $row['sub_drive_description'],
                $row['sub_drive_aditional_desc'],
                $row['sub_drive_target'],
                $row['sub_drive_requirement'],
                $row['sub_drive_img']
            );
            $subDrives[] = $subDrive;
        }

        echo json_encode($subDrives);
        
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to fetch character: ' . $e->getMessage()]);
    }

?>