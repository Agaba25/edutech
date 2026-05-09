<?php
/**
 * API Endpoint: Get Institutions
 * Returns JSON data for institutions
 */

header('Content-Type: application/json');
header('Cache-Control: public, max-age=300'); // Cache for 5 minutes
require_once '../config.php';
require_once '../includes/Database.php';
require_once '../includes/Institution.php';

try {
    $institution = new Institution();
    
    $action = isset($_GET['action']) ? $_GET['action'] : 'list';
    
    // Pagination parameters
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $per_page = isset($_GET['per_page']) ? min(50, max(1, (int)$_GET['per_page'])) : 20;
    $offset = ($page - 1) * $per_page;
    
    if ($action === 'list') {
        $institutions = $institution->getAll($per_page, $offset);
        $total_count = count($institution->getAll());
        $total_pages = ceil($total_count / $per_page);
        
        echo json_encode([
            'success' => true,
            'data' => $institutions,
            'pagination' => [
                'page' => $page,
                'per_page' => $per_page,
                'total' => $total_count,
                'total_pages' => $total_pages
            ]
        ]);
    } elseif ($action === 'get' && isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Invalid ID'
            ]);
            exit;
        }
        
        $inst = $institution->getById($id);
        if ($inst) {
            echo json_encode([
                'success' => true,
                'data' => $inst
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'Institution not found'
            ]);
        }
    } elseif ($action === 'search' && isset($_GET['q'])) {
        $query = trim($_GET['q']);
        if (empty($query)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Search query is required'
            ]);
            exit;
        }
        
        $region = isset($_GET['region']) ? trim($_GET['region']) : null;
        $results = $institution->search($query, $region, $per_page, $offset);
        $total_count = count($institution->search($query, $region));
        $total_pages = ceil($total_count / $per_page);
        
        echo json_encode([
            'success' => true,
            'data' => $results,
            'pagination' => [
                'page' => $page,
                'per_page' => $per_page,
                'total' => $total_count,
                'total_pages' => $total_pages
            ]
        ]);
    } else {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Invalid action. Supported actions: list, get, search'
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => Config::isDevelopment() ? 'Server error: ' . $e->getMessage() : 'Internal server error'
    ]);
}
?>
