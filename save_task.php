<?php
if (isset($_POST['save_task'])) {
    $data = [
        'title' => $_POST['title'],
        'description' => $_POST['description']
    ];

    $ch = curl_init('http://localhost/php_crud/api.php'); // Cambia la URL si es necesario
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    curl_close($ch);

    $_SESSION['message'] = 'Task Saved Successfully';
    $_SESSION['message_type'] = 'success';

    header("Location: index.php");
}
?>
