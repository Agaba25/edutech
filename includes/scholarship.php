<?php
class Scholarship {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllScholarships() {
        return $this->db->fetchAll(
            'SELECT s.*, i.name AS institution_name FROM scholarships s
             LEFT JOIN institutions i ON s.institution_id = i.id
             ORDER BY s.deadline DESC'
        );
    }

    public function getActiveScholarships() {
        $today = date('Y-m-d');
        return $this->db->fetchAll(
            'SELECT s.*, i.name AS institution_name FROM scholarships s
             LEFT JOIN institutions i ON s.institution_id = i.id
             WHERE s.deadline >= ?
             ORDER BY s.deadline ASC',
            [$today]
        );
    }

    public function getScholarshipById($id) {
        return $this->db->fetchOne(
            'SELECT s.*, i.name AS institution_name FROM scholarships s
             LEFT JOIN institutions i ON s.institution_id = i.id WHERE s.id = ?',
            [$id]
        );
    }

    public function addScholarship($institution_id, $title, $amount, $description, $requirements, $deadline, $application_url) {
        $stmt = $this->db->execute(
            'INSERT INTO scholarships (institution_id, title, amount, description, requirements, deadline, application_url)
             VALUES (?, ?, ?, ?, ?, ?, ?)',
            [$institution_id, $title, $amount, $description, $requirements, $deadline, $application_url]
        );
        return (bool) $stmt;
    }

    public function updateScholarship($id, $institution_id, $title, $amount, $description, $requirements, $deadline, $application_url) {
        $stmt = $this->db->execute(
            'UPDATE scholarships SET institution_id = ?, title = ?, amount = ?, description = ?, requirements = ?, deadline = ?, application_url = ? WHERE id = ?',
            [$institution_id, $title, $amount, $description, $requirements, $deadline, $application_url, $id]
        );
        return (bool) $stmt;
    }

    public function deleteScholarship($id) {
        $stmt = $this->db->execute('DELETE FROM scholarships WHERE id = ?', [$id]);
        return (bool) $stmt;
    }

    public function searchScholarships($search_term) {
        $search = '%' . $search_term . '%';
        return $this->db->fetchAll(
            'SELECT s.*, i.name AS institution_name FROM scholarships s
             LEFT JOIN institutions i ON s.institution_id = i.id
             WHERE s.title LIKE ? OR s.description LIKE ? OR i.name LIKE ?
             ORDER BY s.deadline DESC',
            [$search, $search, $search]
        );
    }
}
