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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core/dist/css/tabler.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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

<div class="page-header bg-gray-700 d-print-none text-white pt-5 pb-5">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    <span class="text-decoration-underline">Dashboard</span>
                </div>
                <h2 class="page-title text-black">
                    Statistics Overview
                </h2>
            </div>
        </div>
    </div>
</div>
<div class="container mt-5">
    <?php
    if (isset($user)) {
        echo "<h1 class='text-black text-center'>Welkom, " . $user['naam'] . "</h1>";
    }
    ?>
    <div class="row mb-5">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Boeken:</h3>
                </div>
                <div class="card-body">
                    <?php
                    $result = $db->query("SELECT * FROM boeken");
                    echo "<p>" . count($result) . "</p>";
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gebruikers:</h3>
                </div>
                <div class="card-body">
                    <?php
                    $result = $db->query("SELECT * FROM gebruikers");
                    echo "<p>" . count($result) . "</p>";
                    ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Uitleningen:</h3>
                </div>
                <div class="card-body">
                    <?php
                    $result = $db->query("SELECT * FROM uitleningen");
                    echo "<p>" . count($result) . "</p>";
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Jouw Boeken</h3>
            <div class="card-actions">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBookModal">Nieuw Boek</button>
            </div>
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
                foreach ($result as $boek) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($boek['titel']) . "</td>";
                    echo "<td>" . htmlspecialchars($boek['auteur']) . "</td>";
                    echo "<td>" . htmlspecialchars($boek['publicatiejaar']) . "</td>";
                    echo "<td><a class='text-decoration-underline' href='boeken/view.php?id=" . $boek['id'] . "'>Details</a> ";
                    if($boek['beschikbaar'] == 1) {
                        echo "<a class='text-decoration-underline' onclick='lendBook(" . $boek['id'] . ", " . $user['id'] . ")'>Uitlenen</a> ";
                    } else {
                        echo "<a class='text-decoration-underline' onclick='returnBook(" . $boek['id'] . ", " . $user['id'] . ")'>Geef terug</a> ";
                    }
                    echo "<a class='text-danger text-decoration-underline' href='#' onclick='deleteBook(" . $boek['id'] . ")'>Delete</a></td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Book Modal -->
<div class="modal fade" id="createBookModal" tabindex="-1" aria-labelledby="createBookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createBookModalLabel">Nieuw Boek Toevoegen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createBookForm">
                    <div class="mb-3">
                        <label for="bookName" class="form-label">Naam</label>
                        <input type="text" class="form-control" id="bookName" name="naam" required>
                    </div>
                    <div class="mb-3">
                        <label for="bookAuthor" class="form-label">Auteur</label>
                        <input type="text" class="form-control" id="bookAuthor" name="auteur" required>
                    </div>
                    <div class="mb-3">
                        <label for="publicationYear" class="form-label">Publicatiejaar</label>
                        <input type="number" class="form-control" id="publicationYear" name="publicatiejaar" required>
                    </div>
                    <div class="mb-3">
                        <label for="availability" class="form-label">Beschikbaar</label>
                        <select class="form-select" id="availability" name="beschikbaar" required>
                            <option value="1">Ja</option>
                            <option value="0">Nee</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                <button type="button" class="btn btn-primary" onclick="createBook()">Boek Aanmaken</button>
            </div>
        </div>
    </div>
</div>

<script>
    function lendBook(bookId, userId) {
        const formData = new URLSearchParams();
        formData.append('boek_id', bookId);
        formData.append('gebruiker_id', userId);

        fetch('uitleningen/lenen.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: formData,
        })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload(); // Reload the page to reflect the updated status
            })
            .catch(error => console.error('Error:', error));
    }

    function returnBook(bookId, userId) {
        const formData = new URLSearchParams();
        formData.append('boek_id', bookId);
        formData.append('gebruiker_id', userId);

        fetch('uitleningen/terugbrengen.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: formData,
        })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload(); // Reload the page to reflect the updated status
            })
            .catch(error => console.error('Error:', error));
    }

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

    function createBook() {
        const formData = new FormData(document.getElementById('createBookForm'));

        fetch('boeken/create.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            })
            .catch(error => console.error('Error:', error));
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/@tabler/core/dist/js/tabler.min.js"></script>
</body>
</html>
