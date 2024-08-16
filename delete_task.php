<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $url = 'http://localhost/php_crud/api.php?id=' . $id;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

    $response = curl_exec($ch);
    curl_close($ch);

    $_SESSION['message'] = 'Task Deleted Successfully';
    $_SESSION['message_type'] = 'danger';

    header("Location: index.php");
}
?>
