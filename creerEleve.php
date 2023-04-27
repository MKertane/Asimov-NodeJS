<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asimov - Ajouter un élève</title>
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
        
        if (!isset($_SESSION["idProf"]) && !isset($_SESSION["motDePasse"])) {
            header("location: authentificationProf.php");
        }

        if (isset($_POST["deconnexion"])) {
            session_destroy();
            header("location: authentificationProf.php");
            $_SESSION = [];
        }

        if (isset($_POST["ajouter"])) {
            if (isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["motDePasse"]) && isset($_POST["classe"])) {
                $pdo = new PDO('mysql:host=localhost;dbname=asimov;charset=utf8', 'root', '');
                $nom = $_POST["nom"];
                $prenom = $_POST["prenom"];
                $motDePasse = $_POST["motDePasse"];
                $classe = $_POST["classe"];
                $sql = "INSERT INTO eleve (nom, prenom, motDePasse, idClasse) VALUES (:nom, :prenom, :motDePasse, :idClasse)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":nom", $nom, PDO::PARAM_STR);
                $stmt->bindParam(":prenom", $prenom, PDO::PARAM_STR);
                $stmt->bindParam(":motDePasse", $motDePasse, PDO::PARAM_STR);
                $stmt->bindParam(":idClasse", $classe, PDO::PARAM_INT);
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
    
    <h1>Ajouter un élève</h1>

    <?php
    $pdo = new PDO('mysql:host=localhost;dbname=asimov;charset=utf8', 'root', '');
    ?>
    <!-- FORMULAIRE D'AJOUT D'UN ÉLÈVE -->
    <form method="post">
        
        Nom de l'élève : <input type="text" name="nom" required>
        Prénom de l'élève : <input type="text" name="prenom" required>
        MDP de l'élève : <input type="text" name="motDePasse" required>
        Classe : <select name="classe" id="classe">
            <?php
            $reponse = $pdo->query('SELECT nom FROM classe');
            while ($donnees = $reponse->fetch()) {
            ?> 
                <option value=<?php echo $donnees['nom']; ?>>
                <?php echo $donnees['nom']; ?>
                </option>
			<?php } ?>
        </select>
        <button type="submit" name="ajouter">Ajouter</button>      
    </form>
</body>
</html>