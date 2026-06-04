<?php
// serveur/auth.php

session_start();
header("Content-Type: application/json");
require "connexion_bd.php";

$action = $_POST["action"] ?? "";

// Inscription 
if ($action === "inscription") {
    $nom = trim($_POST["nom"] ?? "");
    $mdp = $_POST["mot_de_passe"] ?? "";

    if (!$nom || !$mdp) {
        echo json_encode(["ok" => false, "message" => "Champs manquants"]); exit;
    }

    $req = $bd->prepare("SELECT id FROM utilisateurs WHERE nom = ?");
    $req->execute([$nom]);
    if ($req->fetch()) {
        echo json_encode(["ok" => false, "message" => "Nom déjà utilisé"]); exit;
    }

    $bd->prepare("INSERT INTO utilisateurs (nom, mot_de_passe) VALUES (?, ?)")
       ->execute([$nom, password_hash($mdp, PASSWORD_DEFAULT)]);

    echo json_encode(["ok" => true]);
}

// Connexion 
elseif ($action === "connexion") {
    $nom = trim($_POST["nom"] ?? "");
    $mdp = $_POST["mot_de_passe"] ?? "";

    $req = $bd->prepare("SELECT * FROM utilisateurs WHERE nom = ?");
    $req->execute([$nom]);
    $user = $req->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($mdp, $user["mot_de_passe"])) {
        echo json_encode(["ok" => false, "message" => "Identifiants incorrects"]); exit;
    }

    $_SESSION["uid"] = $user["id"];
    $_SESSION["nom"] = $user["nom"];
    echo json_encode(["ok" => true, "nom" => $user["nom"]]);
}

// Vérifier session 
elseif ($action === "verifier") {
    if (isset($_SESSION["uid"]))
        echo json_encode(["ok" => true, "nom" => $_SESSION["nom"]]);
    else
        echo json_encode(["ok" => false]);
}

// Déconnexion 
elseif ($action === "deconnexion") {
    session_destroy();
    echo json_encode(["ok" => true]);
}
?>