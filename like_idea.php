<?php
require_once 'db_connect.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    if ($id <= 0) {
        echo json_encode(['success'=>false, 'error'=>'Invalid idea ID']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE ideas SET likes = likes + 1 WHERE id = ?");
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        $stmt2 = $conn->prepare("SELECT likes FROM ideas WHERE id = ?");
        $stmt2->bind_param('i', $id);
        $stmt2->execute();
        $result = $stmt2->get_result()->fetch_assoc();

        echo json_encode(['success'=>true, 'likes'=>$result['likes']]);
    } else {
        echo json_encode(['success'=>false, 'error'=>'Database update failed']);
    }
} else {
    echo json_encode(['success'=>false, 'error'=>'Invalid request']);
}
