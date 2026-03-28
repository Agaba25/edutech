<?php
class Scholarship {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getAllScholarships() {
        $query = "SELECT s.*, i.name as institution_name FROM scholarships s 
                  LEFT JOIN institutions i ON s.institution_id = i.id 
                  ORDER BY s.deadline DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getActiveScholarships() {
        $today = date('Y-m-d');
        $query = "SELECT s.*, i.name as institution_name FROM scholarships s 
                  LEFT JOIN institutions i ON s.institution_id = i.id 
                  WHERE s.deadline >= ? 
                  ORDER BY s.deadline ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $today);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getScholarshipById($id) {
        $query = "SELECT s.*, i.name as institution_name FROM scholarships s 
                  LEFT JOIN institutions i ON s.institution_id = i.id WHERE s.id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function addScholarship($institution_id, $title, $amount, $description, $requirements, $deadline, $application_url) {
        $query = "INSERT INTO scholarships (institution_id, title, amount, description, requirements, deadline, application_url) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('issssss', $institution_id, $title, $amount, $description, $requirements, $deadline, $application_url);
        return $stmt->execute();
    }
    
    public function updateScholarship($id, $title, $amount, $description, $requirements, $deadline, $application_url) {
        $query = "UPDATE scholarships SET title = ?, amount = ?, description = ?, requirements = ?, deadline = ?, application_url = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssssssi', $title, $amount, $description, $requirements, $deadline, $application_url, $id);
        return $stmt->execute();
    }
    
    public function deleteScholarship($id) {
        $query = "DELETE FROM scholarships WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
    
    public function searchScholarships($search_term) {
        $search = "%$search_term%";
        $query = "SELECT s.*, i.name as institution_name FROM scholarships s 
                  LEFT JOIN institutions i ON s.institution_id = i.id 
                  WHERE s.title LIKE ? OR s.description LIKE ? OR i.name LIKE ?
                  ORDER BY s.deadline DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sss', $search, $search, $search);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>