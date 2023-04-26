<?php
session_start();

$sessionEleve = $_SESSION["idEleve"];
$pdo = new PDO('mysql:host=localhost;dbname=asimov;charset=utf8', 'root', '');

$stmt = $pdo->prepare("SELECT matiere.nom AS idMatiere, AVG(note.noteEval) AS moyenne
    FROM note 
    JOIN matiere ON note.idMatiere = matiere.id 
    WHERE idEleve = :idEleve
    GROUP BY matiere.nom
    ORDER BY matiere.nom");
$stmt->bindParam(':idEleve', $sessionEleve, PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($results);