<?php
// serveur/mots_de_passe.php

session_start();
header("Content-Type: application/json");
require "connexion_bd.php";

if (!isset($_SESSION["uid"])) {
    echo json_encode(["ok" => false, "message" => "Non connecté"]); exit;
}

$uid    = $_SESSION["uid"];
$action = $_POST["action"] ?? $_GET["action"] ?? "";

// Chiffrement simple XOR + base64
define("CLE", "coffre_secret_key_hana");

function chiffrer(string $t): string {
    $cle = CLE; $r = "";
    for ($i = 0; $i < strlen($t); $i++)
        $r .= chr(ord($t[$i]) ^ ord($cle[$i % strlen($cle)]));
    return base64_encode($r);
}

function dechiffrer(string $t): string {
    $cle = CLE; $t = base64_decode($t); $r = "";
    for ($i = 0; $i < strlen($t); $i++)
        $r .= chr(ord($t[$i]) ^ ord($cle[$i % strlen($cle)]));
    return $r;
}

// Lire 
if ($action === "lire") {
    $cat = $_GET["categorie"] ?? "Tous";

    if ($cat === "Tous") {
        $req = $bd->prepare(
            "SELECT * FROM mots_de_passe WHERE utilisateur_id = ? ORDER BY ajoute_le DESC"
        );
        $req->execute([$uid]);
    } else {
        $req = $bd->prepare(
            "SELECT * FROM mots_de_passe WHERE utilisateur_id = ? AND categorie = ? ORDER BY ajoute_le DESC"
        );
        $req->execute([$uid, $cat]);
    }

    $liste = $req->fetchAll(PDO::FETCH_ASSOC);
    foreach ($liste as &$e) $e["mot_de_passe"] = dechiffrer($e["mot_de_passe"]);
    echo json_encode(["ok" => true, "donnees" => $liste]);
}

// Ajouter 
elseif ($action === "ajouter") {
    $site  = trim($_POST["site"] ?? "");
    $ident = trim($_POST["identifiant"] ?? "");
    $mdp   = $_POST["mot_de_passe"] ?? "";
    $url   = trim($_POST["url"] ?? "");
    $cat   = $_POST["categorie"] ?? "Personnel";

    if (!$site || !$ident || !$mdp) {
        echo json_encode(["ok" => false, "message" => "Champs obligatoires manquants"]); exit;
    }

    $bd->prepare(
        "INSERT INTO mots_de_passe (utilisateur_id, site, url, identifiant, mot_de_passe, categorie)
         VALUES (?, ?, ?, ?, ?, ?)"
    )->execute([$uid, $site, $url, $ident, chiffrer($mdp), $cat]);

    echo json_encode(["ok" => true]);
}

// Modifier 
elseif ($action === "modifier") {
    $id    = (int)($_POST["id"] ?? 0);
    $site  = trim($_POST["site"] ?? "");
    $ident = trim($_POST["identifiant"] ?? "");
    $mdp   = $_POST["mot_de_passe"] ?? "";
    $url   = trim($_POST["url"] ?? "");
    $cat   = $_POST["categorie"] ?? "Personnel";

    // Vérifier appartenance
    $req = $bd->prepare("SELECT id FROM mots_de_passe WHERE id = ? AND utilisateur_id = ?");
    $req->execute([$id, $uid]);
    if (!$req->fetch()) {
        echo json_encode(["ok" => false, "message" => "Introuvable"]); exit;
    }

    $bd->prepare(
        "UPDATE mots_de_passe SET site=?, url=?, identifiant=?, mot_de_passe=?, categorie=? WHERE id=?"
    )->execute([$site, $url, $ident, chiffrer($mdp), $cat, $id]);

    echo json_encode(["ok" => true]);
}

// Supprimer 
elseif ($action === "supprimer") {
    $id = (int)($_POST["id"] ?? 0);
    $bd->prepare("DELETE FROM mots_de_passe WHERE id = ? AND utilisateur_id = ?")
       ->execute([$id, $uid]);
    echo json_encode(["ok" => true]);
}

else {
    echo json_encode(["ok" => false, "message" => "Action inconnue"]);
}
?>