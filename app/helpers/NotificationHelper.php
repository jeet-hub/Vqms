<?php

require_once __DIR__ . "/../models/Notification.php";

class NotificationHelper
{
    public static function send(
        $sender_id,
        $receiver_id,
        $title,
        $message,
        $type = "general",
        $reference_id = null
    )
    {
        $notification = new Notification();

        return $notification->send(
            $sender_id,
            $receiver_id,
            $title,
            $message,
            $type,
            $reference_id
        );
    }
}

?>