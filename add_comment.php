<?php
require_once 'db_connect.php';
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idea_id'], $_POST['comment_text'])) {
    $idea_id = intval($_POST['idea_id']);
    $comment_text = trim($_POST['comment_text']);
    $date_posted = date('Y-m-d H:i:s'); // Current timestamp

    if ($idea_id <= 0 || $comment_text === '') {
        echo json_encode(['success'=>false, 'message'=>'Invalid input']);
        exit;
    }
    $stmt = $conn->prepare("INSERT INTO comments (idea_id, comment_text, date_posted) VALUES (?, ?, ?)");
    $stmt->bind_param('iss', $idea_id, $comment_text, $date_posted);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'comment' => [
                'comment_text' => htmlspecialchars($comment_text),
                'date_posted' => $date_posted
            ]
        ]);
    } else {
        echo json_encode(['success'=>false, 'message'=>'Database insert failed']);
    }
} else {
    echo json_encode(['success'=>false, 'message'=>'Invalid request']);
}
