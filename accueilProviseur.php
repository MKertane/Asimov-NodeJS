<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js">
    </script>
</head>
<body>
    <form method="post">
        <input type="submit" name="deconnexion" value="Se déconnecter">
    </form>
<?php
    session_start();
    if (isset ($_SESSION ["error"]) && ($_SESSION ["error"]!=""))
    echo ("<br/><div style=\"background-color: #f44; padding: 6px;\">" . ($_SESSION ["error"]) . "</div>");
    $_SESSION ["error"]="";

    if (isset ($_SESSION ["info"]) && ($_SESSION ["info"]!=""))
    echo ("<br/><div style=\"background-color: #4f4; padding: 6px;\">" . ($_SESSION ["info"]) . "</div>");
    $_SESSION ["info"]="";

    $pdo = new PDO('mysql:host=localhost;dbname=asimov;charset=utf8', 'root', '');

    try {
        
        // Redirection si l'utilisateur ne s'est pas authentifié
        if (!isset($_SESSION["idProviseur"]) && !isset($_SESSION["motDePasse"])) {
            header("location: authentificationProviseur.php");
        }

        // Déconnexion de l'utilisateur
        if (isset($_POST["deconnexion"])) {
            session_destroy();
            header("location: authentificationProviseur.php");
            $_SESSION = [];
        }

    }

    catch(Exception $e){
        die("LES PROBLEMES :" . $e->getMessage());
    }
?>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="modifierNotes.php">Mofifier les notes</a></li>
            <li class="nav-item"><a class="nav-link" href="creerMatiere.php">Créer une matière</a></li>
            <li class="nav-item"><a class="nav-link" href="creerProf.php">Créer un Professeur</a></li>
        </ul>
    </div>
</nav>
</body>
</html>