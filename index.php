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
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home</a>
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
        <div style="display: flex; column-gap: 35px; column-count: 1" class="mb-5">
            <div class="w-33">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title">Boeken:</h1>
                    </div>
                    <div class="card-body">
                    <?php
                        $result = $db->query("SELECT * FROM boeken");
                        $boeken = $result;
                    echo "<p>" . count($result) . "</p>";
                    ?>
                    </div>
                </div>
            </div>
            <div class="w-33">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title">Gebruikers:</h1>
                    </div>
                    <div class="card-body">
                    <?php
                    $result = $db->query("SELECT * FROM gebruikers");
                    $boeken = $result;
                    echo "<p>" . count($result) . "</p>";
                    ?>
                    </div>
                </div>
            </div>
            <div class="w-33">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title">Uitleningen:</h1>
                    </div>
                    <div class="card-body">
                    <?php
                    $result = $db->query("SELECT * FROM uitleningen");
                    $boeken = $result;
                    echo "<p>" . count($result) . "</p>";
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Jouw Boeken</h1>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Titel</th>
                        <th>Auteur</th>
                        <th>Jaar</th>
                        <th></th>
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
                        echo "<td><a class='text-decoration-underline' href='boeken/view.php?id=" . $boek['id'] . "'>Details</a>    <a class='text-red text-decoration-underline' href='#' onclick='deleteBook(" . $boek['id'] . ")'>Delete</a></td>";                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function deleteBook(id) {
            if (confirm('Ben je zeker dat je dit boek wilt verwijderen?')) {
                fetch('boeken/delete.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'id': id
                    })
                })
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        location.reload();
                    })
                    .catch(error => console.error('Error:', error));
            }
        }
    </script>
</nav>
</body>
</html>
