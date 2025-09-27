<?php
// functions.php

function fetchChatHistory($pdo, $user_id, $partner_id) {
    $query = "
        SELECT c.message, c.timestamp, u.username AS sender_username, ur.username AS receiver_username
        FROM chats c
        INNER JOIN users u ON c.sender_id = u.user_id
        INNER JOIN users ur ON c.receiver_id = ur.user_id
        WHERE (c.sender_id = ? AND c.receiver_id = ?) OR (c.sender_id = ? AND c.receiver_id = ?)
        ORDER BY c.timestamp ASC";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id, $partner_id, $partner_id, $user_id]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// You can add more functions here if needed
?>

