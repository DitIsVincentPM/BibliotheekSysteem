<?php
require '../classes/DatabaseOperations.php';

if (isset($_POST['publicatiejaar']) && isset($_POST['naam']) && isset($_POST['auteur']) && isset($_POST['beschikbaar'])) {
    $publicatiejaar = $_POST['publicatiejaar'];
    $naam = $_POST['naam'];
    $auteur = $_POST['auteur'];
    $beschikbaar = $_POST['beschikbaar'];

    $db = new DatabaseOperations();
    $db->insert("boeken", [$publicatiejaar, $naam, $auteur, $beschikbaar]);
    echo "Book created successfully";
} else {
    echo "Missing parameters";
}
?>