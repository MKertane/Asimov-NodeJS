<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asimov - Ajouter un Professeur</title>
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

        // Ajouter un professeur dans la base de données
        if (isset($_POST["ajouter"])) {
            if (isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["motDePasse"]) && isset($_POST["classe"])) {
                $pdo = new PDO('mysql:host=localhost;dbname=asimov;charset=utf8', 'root', '');
                $nom = $_POST["nom"];
                $prenom = $_POST["prenom"];
                $motDePasse = $_POST["motDePasse"];
                $idMatiere = $_POST["idMatiere"];
                $accesBeta = $_POST["accesBeta"];
                $accesAlpha = $_POST["accesAlpha"];                
                $estReferent = $_POST["estReferent"];
                $sql = "INSERT INTO professeur (nom, prenom, motDePasse, idMatiere, accesBeta, accesAlpha, estReferent)
                VALUES (:nom, :prenom, :motDePasse, :idMatiere, :accesBeta, :accesAlpha, :estReferent)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":nom", $nom, PDO::PARAM_STR);
                $stmt->bindParam(":prenom", $prenom, PDO::PARAM_STR);
                $stmt->bindParam(":motDePasse", $motDePasse, PDO::PARAM_STR);
                $stmt->bindParam(":idMatiere", $idMatiere, PDO::PARAM_STR);
                $stmt->bindParam(":accesBeta", $accesBeta, PDO::PARAM_BOOL);
                $stmt->bindParam(":accesAlpha", $accesAlpha, PDO::PARAM_BOOL);
                $stmt->bindParam(":estReferent", $estReferent, PDO::PARAM_BOOL);
                $_SESSION ["info"] = "Professeur ajouté avec succès";

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
    
    <h1>Ajouter un Professeur</h1>

    <?php
    $pdo = new PDO('mysql:host=localhost;dbname=asimov;charset=utf8', 'root', '');
    ?>

    <!-- FORMULAIRE D'AJOUT D'UN PROFESSEUR -->
    <form method="post">
        
        Nom du professeur : <input type="text" name="nom" required>
        Prénom du professeur : <input type="text" name="prenom" required>
        MDP du professeur : <input type="text" name="motDePasse" required>
        Matière : <select name="idMatiere" id="idMatiere" required>
            <?php
            $reponse = $pdo->query('SELECT * FROM matiere');
            while ($donnees = $reponse->fetch()) {
            ?> 
                <option value=<?php echo $donnees['id']; ?>>
                <?php echo $donnees['nom']; ?>
                </option>
			<?php } ?>
        </select>
        <br>
        <label for="BETA">Accès Beta :</label>
        <input type="radio" name="accesBeta" value="1">Oui
        <input type="radio" name="accesBeta" value="0">Non
        <br>
        <label for="ALPHA">Accès Alpha :</label>
        <input type="radio" name="accesAlpha" value="1">Oui
        <input type="radio" name="accesAlpha" value="0">Non
        <br>
        <label for="REFERENT">Professeur référent :</label>
        <input type="radio" name="estReferent" value="1">Oui
        <input type="radio" name="estReferent" value="0">Non

        <button type="submit" name="ajouter">Ajouter</button>      
    </form>
</body>
</html>