<?php
/**
 * Contact Message Model Class
 */

class Contact {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Get all messages
    public function getAll($status = null) {
        if ($status) {
            return $this->db->fetchAll(
                'SELECT * FROM contact_messages WHERE status = ? ORDER BY created_at DESC',
                [$status]
            );
        }
        return $this->db->fetchAll('SELECT * FROM contact_messages ORDER BY created_at DESC');
    }

    // Get message by ID
    public function getById($id) {
        return $this->db->fetchOne(
            'SELECT * FROM contact_messages WHERE id = ?',
            [$id]
        );
    }

    // Create message
    public function create($data) {
        $query = 'INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)';
        
        $stmt = $this->db->execute($query, [
            $data['name'],
            $data['email'],
            $data['subject'] ?? null,
            $data['message']
        ]);

        return $stmt ? $this->db->lastInsertId() : false;
    }

    // Update message status
    public function updateStatus($id, $status) {
        $stmt = $this->db->execute(
            'UPDATE contact_messages SET status = ? WHERE id = ?',
            [$status, $id]
        );
        return $stmt ? true : false;
    }

    // Delete message
    public function delete($id) {
        $stmt = $this->db->execute('DELETE FROM contact_messages WHERE id = ?', [$id]);
        return $stmt ? true : false;
    }

    // Get unread count
    public function getUnreadCount() {
        $result = $this->db->fetchOne(
            'SELECT COUNT(*) as count FROM contact_messages WHERE status = ?',
            ['new']
        );
        return $result['count'] ?? 0;
    }
}
?>
