<?php
require '../classes/DatabaseOperations.php';

if (!empty($_GET['gebruikerid']) && !empty($_GET['boek_id'])) {
    $gebruikerid = $_GET['gebruikerid'];
    $boekid = $_GET['boek_id'];

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
} else {
    echo "Ontbrekende parameters!";
}
?>
