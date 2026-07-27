<?php

require_once __DIR__ . "/../config/database.php";

class Notification
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Send Notification
    public function send($sender_id, $receiver_id, $title, $message, $type = 'general', $reference_id = null)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO notifications
            (
                sender_id,
                receiver_id,
                title,
                message,
                type,
                reference_id
            )
            VALUES
            (
                ?,?,?,?,?,?
            )
        ");

        return $stmt->execute([
            $sender_id,
            $receiver_id,
            $title,
            $message,
            $type,
            $reference_id
        ]);
    }

    // Get all notifications of a user
    public function getByUser($user_id)
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM notifications
            WHERE receiver_id = ?
            ORDER BY created_at DESC
        ");

        $stmt->execute([$user_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Unread Count
    public function getUnreadCount($user_id)
    {
        $stmt = $this->conn->prepare("
            SELECT COUNT(*)
            FROM notifications
            WHERE receiver_id=?
            AND is_read=0
        ");

        $stmt->execute([$user_id]);

        return $stmt->fetchColumn();
    }

    // Mark One Read
    public function markAsRead($id)
    {
        $stmt = $this->conn->prepare("
            UPDATE notifications
            SET is_read=1
            WHERE id=?
        ");

        return $stmt->execute([$id]);
    }

    // Mark All Read
    public function markAllRead($user_id)
    {
        $stmt = $this->conn->prepare("
            UPDATE notifications
            SET is_read=1
            WHERE receiver_id=?
        ");

        return $stmt->execute([$user_id]);
    }

    // Delete Notification
    public function delete($id)
    {
        $stmt = $this->conn->prepare("
            DELETE FROM notifications
            WHERE id=?
        ");

        return $stmt->execute([$id]);
    }
}