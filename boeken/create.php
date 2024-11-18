<?php
require '../classes/DatabaseOperations.php';

if (!empty($_POST['publicatiejaar']) && !empty($_POST['naam']) && !empty($_POST['auteur']) && isset($_POST['beschikbaar'])) {
    $publicatiejaar = $_POST['publicatiejaar'];
    $naam = $_POST['naam'];
    $auteur = $_POST['auteur'];
    $beschikbaar = filter_var($_POST['beschikbaar'], FILTER_VALIDATE_BOOLEAN);

    $db = new DatabaseOperations();

    // Voer de INSERT uit
    if ($db->insert("boeken", [
        "publicatiejaar" => $publicatiejaar,
        "titel" => $naam,
        "auteur" => $auteur,
        "beschikbaar" => $beschikbaar
    ])) {
        echo "Boek succesvol toegevoegd!";
    } else {
        echo "Er is een fout opgetreden bij het toevoegen van het boek.";
    }
} else {
    echo "Ontbrekende parameters!";
}
?>
