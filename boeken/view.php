<?php
require '../classes/DatabaseOperations.php';
$db = new DatabaseOperations();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $db->query("SELECT * FROM boeken WHERE id = ?", [$id]);
    $boek = $result[0];
} else {
    die("Boek ID is niet opgegeven.");
}
?>

<html>
<head>
    <title><?php echo $boek['titel']; ?></title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="../index.php">Home</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title"><?php echo $boek['titel']; ?></h1>
        </div>
        <div class="card-body">
            <p><strong>Auteur:</strong> <?php echo $boek['auteur']; ?></p>
            <p><strong>Jaar:</strong> <?php echo $boek['publicatiejaar']; ?></p>
        </div>
    </div>
</div>
</body>
</html>