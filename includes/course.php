<?php
class Course {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getAllCourses($level = null) {
        $query = "SELECT c.*, i.name as institution_name FROM courses c 
                  JOIN institutions i ON c.institution_id = i.id";
        
        if ($level) {
            $query .= " WHERE c.level = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('s', $level);
        } else {
            $stmt = $this->db->prepare($query);
        }
        
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getCourseById($id) {
        $query = "SELECT c.*, i.name as institution_name FROM courses c 
                  JOIN institutions i ON c.institution_id = i.id WHERE c.id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function getCoursesByInstitution($institution_id) {
        $query = "SELECT * FROM courses WHERE institution_id = ? ORDER BY level, name";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $institution_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function addCourse($institution_id, $name, $level, $duration, $fee_estimate, $description, $requirements) {
        $query = "INSERT INTO courses (institution_id, name, level, duration, fee_estimate, description, requirements) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('issssss', $institution_id, $name, $level, $duration, $fee_estimate, $description, $requirements);
        return $stmt->execute();
    }
    
    public function updateCourse($id, $name, $level, $duration, $fee_estimate, $description, $requirements) {
        $query = "UPDATE courses SET name = ?, level = ?, duration = ?, fee_estimate = ?, description = ?, requirements = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssssssi', $name, $level, $duration, $fee_estimate, $description, $requirements, $id);
        return $stmt->execute();
    }
    
    public function deleteCourse($id) {
        $query = "DELETE FROM courses WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
    
    public function searchCourses($search_term) {
        $search = "%$search_term%";
        $query = "SELECT c.*, i.name as institution_name FROM courses c 
                  JOIN institutions i ON c.institution_id = i.id 
                  WHERE c.name LIKE ? OR c.description LIKE ? OR i.name LIKE ?
                  ORDER BY c.name";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sss', $search, $search, $search);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
