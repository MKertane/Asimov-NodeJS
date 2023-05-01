<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asimov - Accueil Professeurs</title>
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
        if (!isset($_SESSION["idProf"]) && !isset($_SESSION["motDePasse"])) {
            header("location: authentificationProf.php");
        }

        // Déconnexion de l'utilisateur
        if (isset($_POST["deconnexion"])) {
            session_destroy();
            header("location: authentificationProf.php");
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
            <?php $pdo = new PDO('mysql:host=localhost;dbname=asimov;charset=utf8', 'root', ''); ?>
            <?php if (isset($_SESSION["accesBeta"]) && $_SESSION["accesBeta"]) { ?>
                <li class="nav-item"><a class="nav-link" href="saisirNotesBeta.php">Ajouter une note (Bêta)</a></li>
            <?php } else { ?>
                <li class="nav-item"><a class="nav-link disabled" href="#">Ajouter une note (Bêta)</a></li>
            <?php } ?>

            <?php if (isset($_SESSION["accesAlpha"]) && $_SESSION["accesAlpha"]) { ?>
                <li class="nav-item"><a class="nav-link" href="saisirNotesAlpha.php">Ajouter une note (Alpha)</a></li>
            <?php } else { ?>
                <li class="nav-item"><a class="nav-link disabled" href="#">Ajouter une note (Alpha)</a></li>
            <?php } ?>
                
            <?php if (isset($_SESSION["estReferent"]) && $_SESSION["estReferent"]) { ?>
                <li class="nav-item"><a class="nav-link" href="creerEleve.php">Créer un élève</a></li>
            <?php } else { ?>
                <li class="nav-item"><a class="nav-link disabled" href="#">Créer un élève</a></li>
            <?php } ?>
        </ul>
    </div>
</nav>
</body>
</html>