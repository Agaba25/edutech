<?php
/**
 * API Endpoint: Get Programs
 * Returns JSON data for programs
 */

header('Content-Type: application/json');
require_once '../config.php';
require_once '../includes/Database.php';
require_once '../includes/Program.php';

try {
    $program = new Program();
    
    $action = isset($_GET['action']) ? $_GET['action'] : 'list';
    
    if ($action === 'list') {
        $programs = $program->getAll();
        echo json_encode([
            'success' => true,
            'data' => $programs
        ]);
    } elseif ($action === 'get' && isset($_GET['id'])) {
        $prog = $program->getById((int)$_GET['id']);
        if ($prog) {
            echo json_encode([
                'success' => true,
                'data' => $prog
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'Program not found'
            ]);
        }
    } elseif ($action === 'by_institution' && isset($_GET['institution_id'])) {
        $programs = $program->getByInstitution((int)$_GET['institution_id']);
        echo json_encode([
            'success' => true,
            'data' => $programs
        ]);
    } elseif ($action === 'by_level' && isset($_GET['level'])) {
        $programs = $program->getByLevel($_GET['level']);
        echo json_encode([
            'success' => true,
            'data' => $programs
        ]);
    } else {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Invalid action'
        ]);
    }
} catch (Exception $e) {
    error_log('API programs error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => Config::isDevelopment() ? 'Server error: ' . $e->getMessage() : 'Internal server error',
    ]);
}
?>
