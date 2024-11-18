<?php
require '../classes/DatabaseOperations.php';

if (!empty($_POST['gebruiker_id']) && !empty($_POST['boek_id'])) {
    $gebruikerid = $_POST['gebruiker_id'];
    $boekid = $_POST['boek_id'];

    $db = new DatabaseOperations();

    $result = $db->query("SELECT * FROM boeken WHERE id = ?", [$boekid]);
    $boek = $result[0];
    if($boek['beschikbaar'] == 1) {
        echo "Boek is niet uitgeleend!";
        die();
    }

    $currentDateTime = date('Y-m-d H:i:s');

    if ($db->update("uitleningen", [
        'teruggebracht_op' => $currentDateTime,
    ], [
        "gebruiker_id" => $gebruikerid,
        "boek_id" => $boekid,
    ])) {
        echo "Boek successvol terug gegeven!";
    } else {
        echo "Er is een fout opgetreden bij het uitlenen van het boek.";
    }

    if($db->update('boeken', ['beschikbaar' => 1], ['id' => $boekid])) {
        echo "Boek status aangepast!";
    } else {
        echo "Er is een fout opgetreden bij het aanpassen van de boek status.";
    }
} else {
    echo "Ontbrekende parameters!";
}
?>