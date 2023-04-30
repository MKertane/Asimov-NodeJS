<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asimov - Ajouter une note (Alpha) </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
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
        // Redirection si le professeur ne s'est pas authentifié
        if (!isset($_SESSION["idProf"]) && !isset($_SESSION["motDePasse"])) {
            header("location: authentificationProf.php");
        }

        // Déconnexion du professeur
        if (isset($_POST["deconnexion"])) {
            session_destroy();
            header("location: authentificationProf.php");
            $_SESSION = [];
        }

        
        // Ajouter une note à un élève dans la base de données
        if (isset($_POST["ajouter"])) {
            if (isset($_POST["eleve"]) && isset($_POST["note"]) && isset($_POST["matiere"]) ) {
                $idProf = $_SESSION["idProf"];
                $pdo = new PDO('mysql:host=localhost;dbname=asimov;charset=utf8', 'root', '');
                $note = $_POST["note"];
                $eleve = $_POST["eleve"];
                $matiere = $_POST["matiere"];
                $sql = "INSERT INTO note (idEleve, idMatiere, idProf, noteEval) VALUES (:eleve, :matiere, :prof, :note)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":eleve", $eleve, PDO::PARAM_INT);
                $stmt->bindParam(":matiere", $matiere, PDO::PARAM_INT);
                $stmt->bindParam(":note", $note, PDO::PARAM_STR); 
                $stmt->bindParam(":prof", $idProf, PDO::PARAM_INT);
                try {
                    $stmt->execute();
                }
                catch(Exception $e){
                    die("LES PROBLEMES :" . $e->getMessage());
                }
                $_SESSION ["info"]="Note ajoutée avec succès";
            }  
        }
    }

    catch(Exception $e){
        die("LES PROBLEMES :" . $e->getMessage());
    }   
    ?>

    <h1>Ajouter une note</h1>

    <?php
    $pdo = new PDO('mysql:host=localhost;dbname=asimov;charset=utf8', 'root', '');
    ?>

    <!-- FORMULAIRE D'AJOUT D'UNE NOTE À UN ÉLÈVE -->
    <form method="post">
        
        Élève : <select name="eleve" id="eleve" required>
            <?php
                $reponse = $pdo->query('SELECT idEleve, nom, prenom FROM eleve');
                while ($donnees = $reponse->fetch()) {
                ?> 
                    <option value=<?php echo $donnees['idEleve']; ?>>
                    <?php echo $donnees['nom']; ?>
                    <?php echo $donnees['prenom']; ?>
                    </option>
			    <?php } ?>
            </select>

        Note sur 20 : <input type="number" name="note" id="note" required>

        Matière : <select name="matiere" id="matiere" required>
            <?php
            $reponse = $pdo->query('SELECT * FROM matiere');
            while ($donnees = $reponse->fetch()) {
            ?> 
                <option value=<?php echo $donnees['id']; ?>>
                <?php echo $donnees['nom']; ?>
                </option>
			<?php } ?>
        </select>
        <button type="submit" name="ajouter">Ajouter</button>      
    </form>
</body>
</html>