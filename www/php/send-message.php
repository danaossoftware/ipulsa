<?php
$attachmentURL = $_POST["attachment-url"];
include 'db.php';
include 'common.php';
$receiverId = $_POST["receiver-id"];
$message = $_POST["message"];
$attachmentType = $_POST["attachment-type"];
$address = $_POST["address"];
$latitude = $_POST["latitude"];
$longitude = $_POST["longitude"];
$senderId = getUserID();
$language = $_POST["language"];
$date = round(microtime(true)*1000);
$c->query("INSERT INTO messages (id, sender_id, receiver_id, message, sent_date, attachment, attachment_type) VALUES ('" . uniqid() . "', '" . $senderId . "', '" . $receiverId . "', '" . $message . "', '" . $date . "', '" . $attachmentURL . "', '" . $attachmentType . "', '" . $address . "', " . $latitude . ", " . $longitude . ")");
$results = $c->query("SELECT * FROM last_messages WHERE sender_id='" . $senderId . "' AND receiver_id='" . $receiverId . "'");
if ($results && $results->num_rows > 0) {
    if ($attachmentURL == "") {
        if ($address == "") {
            $c->query("UPDATE last_messages SET last_message='" . $message . "' WHERE sender_id='" . $senderId . "' AND receiver_id='" . $receiverId . "'");
        } else {
            if ($language == 0) {
                $c->query("UPDATE last_messages SET last_message='Lokasi' WHERE sender_id='" . $senderId . "' AND receiver_id='" . $receiverId . "'");
            } else if ($language == 1) {
                $c->query("UPDATE last_messages SET last_message='Location' WHERE sender_id='" . $senderId . "' AND receiver_id='" . $receiverId . "'");
            }
        }
    } else {
        $c->query("UPDATE last_messages SET last_message='Media' WHERE sender_id='" . $senderId . "' AND receiver_id='" . $receiverId . "'");
    }
} else {
    $results = $c->query("SELECT * FROM last_messages WHERE sender_id='" . $receiverId . "' AND receiver_id='" . $senderId . "'");
    if ($results && $results->num_rows > 0) {
        if ($attachmentURL == "") {
            if ($address == "") {
                $c->query("UPDATE last_messages SET last_message='" . $message . "' WHERE sender_id='" . $receiverId . "' AND receiver_id='" . $senderId . "'");
            } else {
                if ($language == 0) {
                    $c->query("UPDATE last_messages SET last_message='Lokasi' WHERE sender_id='" . $receiverId . "' AND receiver_id='" . $senderId . "'");
                } else if ($language == 1) {
                    $c->query("UPDATE last_messages SET last_message='Location' WHERE sender_id='" . $receiverId . "' AND receiver_id='" . $senderId . "'");
                }
            }
        } else {
            $c->query("UPDATE last_messages SET last_message='Media' WHERE sender_id='" . $receiverId . "' AND receiver_id='" . $senderId . "'");
        }
    } else {
        if ($attachmentURL == "") {
            if ($address == "") {
                $c->query("INSERT INTO last_messages (id, sender_id, receiver_id, last_message) VALUES ('" . uniqid() . "', '" . $senderId . "', '" . $receiverId . "', '" . $message . "')");
            } else {
                if ($language == 0) {
                    $c->query("INSERT INTO last_messages (id, sender_id, receiver_id, last_message) VALUES ('" . uniqid() . "', '" . $senderId . "', '" . $receiverId . "', 'Lokasi')");
                } else if ($language == 1) {
                    $c->query("INSERT INTO last_messages (id, sender_id, receiver_id, last_message) VALUES ('" . uniqid() . "', '" . $senderId . "', '" . $receiverId . "', 'Location')");
                }
            }
        } else {
            $c->query("INSERT INTO last_messages (id, sender_id, receiver_id, last_message) VALUES ('" . uniqid() . "', '" . $senderId . "', '" . $receiverId . "', 'Media')");
        }
    }
}