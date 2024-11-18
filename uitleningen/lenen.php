<?php
require '../classes/DatabaseOperations.php';

if (!empty($_POST['gebruiker_id']) && !empty($_POST['boek_id'])) {
    $gebruikerid = $_POST['gebruiker_id'];
    $boekid = $_POST['boek_id'];

    $db = new DatabaseOperations();

    $result = $db->query("SELECT * FROM boeken WHERE id = ?", [$boekid]);
    $boek = $result[0];
    if($boek['beschikbaar'] == 0) {
        echo "Boek is niet beschikbaar!";
        die();
    }

    if ($db->insert("uitleningen", [
        "gebruiker_id" => $gebruikerid,
        "boek_id" => $boekid,
    ])) {
        echo "Boek successvol uitgeleend!";
    } else {
        echo "Er is een fout opgetreden bij het uitlenen van het boek.";
    }
    if($db->update('boeken', ['beschikbaar' => 0], ['id' => $boekid])) {
        echo "Boek status aangepast!";
    } else {
        echo "Er is een fout opgetreden bij het aanpassen van de boek status.";
    }
} else {
    echo "Ontbrekende parameters!";
}
?>
