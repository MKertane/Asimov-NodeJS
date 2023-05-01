<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asimov - Ajouter une matière</title>
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

        // Ajouter une matière dans la base de données
        if (isset($_POST["ajouter"])) {
            if (isset($_POST["nom"])) {
                $pdo = new PDO('mysql:host=localhost;dbname=asimov;charset=utf8', 'root', '');
                $nom = $_POST["nom"];
                $sql = "INSERT INTO matiere (nom) VALUES (:nom)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":nom", $nom, PDO::PARAM_STR);
                $_SESSION ["info"] = "Matière créée avec succès";
                try {
                    $stmt->execute();
                }
                catch(Exception $e){
                    die("LES PROBLEMES :" . $e->getMessage());
                }
            }  
        }
    }

    catch(Exception $e){
        die("LES PROBLEMES :" . $e->getMessage());
    }
    ?>
    
    <h1>Ajouter une matière</h1>

    <?php
    $pdo = new PDO('mysql:host=localhost;dbname=asimov;charset=utf8', 'root', '');
    ?>
    <!-- FORMULAIRE D'AJOUT D'UNE MATIÈRE -->
    <form method="post">
        
        Nom de l'élève : <input type="text" name="nom" required>
        <button type="submit" name="ajouter">Ajouter</button>      
    </form>
</body>
</html>