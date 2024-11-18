<?php
require '../classes/DatabaseOperations.php';

if (isset($_POST['id'])) {
    $db = new DatabaseOperations();
    $id = $_POST['id'];
    $db->delete('boeken', 'id = ' . $id);
    echo "Book deleted successfully";
}
?>