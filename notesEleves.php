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

    try {
        
        if (!isset($_SESSION["idEleve"]) && !isset($_SESSION["motDePasse"])) {
            header("location: authentificationEleve.php");
        }

        if (isset($_POST["deconnexion"])) {
            session_destroy();
            header("location: authentificationEleve.php");
            $_SESSION = [];
        }
    }

    catch(Exception $e){
        die("LES PROBLEMES :" . $e->getMessage());
    }

    ?>

    <h1>Vos notes</h1>

    <?php
    $sessionEleve = $_SESSION["idEleve"];
    $pdo = new PDO('mysql:host=localhost;dbname=asimov;charset=utf8', 'root', '');
    $req = "SELECT matiere.nom AS idMatiere, note.noteEval 
        FROM note 
        JOIN matiere ON note.idMatiere = matiere.id 
        WHERE idEleve = $sessionEleve
        ORDER BY matiere.nom";
    $stmt = $pdo->prepare($req);
    $stmt->execute();

    // Afficher les informations dans un tableau HTML
    ?>
    <table>
        <tr>
            <th>Matière<th>
            <th>Note<th>
        </tr>
    </table>
    
    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row["idMatiere"] . "</td>";
        echo "<td>" . $row["noteEval"] . "</td>";
        echo "<tr>";
    }
    ?>
</body>
</html>