<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asimov - Connexion Proviseur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php
    session_start();
    if (isset ($_SESSION ["error"]) && ($_SESSION ["error"]!=""))
    echo ("<br/><div style=\"background-color: #f44; padding: 6px;\">" . ($_SESSION ["error"]) . "</div>");
    $_SESSION ["error"]="";

    if (isset ($_SESSION ["info"]) && ($_SESSION ["info"]!=""))
    echo ("<br/><div style=\"background-color: #4f4; padding: 6px;\">" . ($_SESSION ["info"]) . "</div>");
    $_SESSION ["info"]="";

    try {

        if (isset($_POST["deconnexion"])) {
            session_destroy();
            header("location: authentificationProviseur.php");
            $_SESSION = [];
        }



        if (isset($_POST["id"]) && isset($_POST["motDePasse"])) {
            $pdo = new PDO('mysql:host=localhost;dbname=asimov;charset=utf8', 'root', '');
            $id = $_POST["id"];
            $motDePasse = $_POST["motDePasse"];
            $sql = "SELECT * FROM proviseur WHERE idProviseur = :idProviseur AND motDePasse = :motDePasse";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":idProviseur", $id, PDO::PARAM_STR);
            $stmt->bindParam(":motDePasse", $motDePasse, PDO::PARAM_STR);
            $stmt->execute();
            if ($row = $stmt->fetch()) {
            
                $_SESSION["idProviseur"] = $row["idProviseur"];
                $_SESSION["motDePasse"] = $row["motDePasse"];

                header("location: accueilProviseur.php");     
            }
            
            else {echo("Identifiant ou mot de passe incorrect");}
            
        }
                
    }  

    catch(Exception $e){
        die("LES PROBLEMES :" . $e->getMessage());
    }
    ?>
    
<br><br>

    <?php
    if (isset($_SESSION["idProviseur"])) { ?>
        <form method="post">
        <input type="submit" name="deconnexion" value="Se déconnecter">
        </form>
        <?php
        ?>
    <?php
    }
    else { ?>
        <form name="asimov_authentification" method="post">
        Identifiant : <input type="number" name="id" min="1" required/>
        Mot de passe : <input type="password" name="motDePasse" required/>
        <p><input type="submit" value="Se connecter"></p>
        </form>
    <?php 
    }
    ?>
</body>
</html>