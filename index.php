<?php
require 'classes/DatabaseOperations.php';

$db = new DatabaseOperations();

// Query example
$result = $db->query("SELECT * FROM gebruikers WHERE naam = ?", ['Vincent']);
$user = $result[0];
?>

<html>
<head>
    <title>Boeken</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Boeken</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Gebruikers</a>
            </li>
            <?php
            if (isset($user)) {
                echo "<li class='nav-item ml-auto user-nav-item'><a class='nav-link' href=''>" . $user['naam'] . "</a></li>";
            } else {
                echo '<li class="nav-item ml-auto user-nav-item"><a class="nav-link" href="">Login</a></li>';
            }
            ?>

        </ul>
    </div>
</nav>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Boeken</h1>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Titel</th>
                        <th>Auteur</th>
                        <th>Jaar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $result = $db->query("SELECT * FROM boeken");
                    $boeken = $result;

                    foreach ($boeken as $boek) {
                        echo "<tr>";
                        echo "<td>" . $boek['titel'] . "</td>";
                        echo "<td>" . $boek['auteur'] . "</td>";
                        echo "<td>" . $boek['publicatiejaar'] . "</td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</nav>
</body>
</html>
