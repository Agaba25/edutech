<?php
/**
 * Course finder catalogue (`courses` + `course_universities`). See database_enhanced.sql.
 */
class Course {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /** @deprecated Courses rows do not include level; filter ignored */
    public function getAllCourses($level = null) {
        return $this->db->fetchAll('SELECT * FROM courses ORDER BY name ASC');
    }

    public function getCourseById($id) {
        return $this->db->fetchOne('SELECT * FROM courses WHERE id = ?', [$id]);
    }

    public function getCoursesByInstitution($institution_id) {
        return $this->db->fetchAll(
            'SELECT c.* FROM courses c
             INNER JOIN course_universities cu ON cu.course_id = c.id
             WHERE cu.institution_id = ?
             ORDER BY c.name ASC',
            [$institution_id]
        );
    }

    public function searchCourses($search_term) {
        $search = '%' . $search_term . '%';
        return $this->db->fetchAll(
            'SELECT * FROM courses WHERE name LIKE ? OR description LIKE ?
             ORDER BY name ASC',
            [$search, $search]
        );
    }
}
