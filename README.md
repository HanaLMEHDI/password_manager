<div align="center">

# 🔐 Coffre

### Gestionnaire de mots de passe — Full Stack

<br>

> Application web de gestion de mots de passe développée **from scratch** — authentification sécurisée, chiffrement, interface moderne inspirée des apps professionnelles (Bitwarden, 1Password).

<br>

</div>

---

## 📸 Aperçu

| Page connexion | Application principale |
|:-:|:-:|
| *Connexion & Inscription* | *Dashboard — liste + détail* |

> 💡 Ajoute tes propres screenshots après lancement : `Interface/connexion.html` et `Interface/principale.html`

---

## ✨ Fonctionnalités

| Fonctionnalité | Détail |
|---|---|
| 🔐 Authentification | Inscription & connexion avec hachage **bcrypt** |
| 🗂️ Catégories | Tous · Travail · Personnel · Favoris |
| ✏️ CRUD complet | Ajouter, modifier, supprimer des entrées |
| 🔍 Recherche | Filtrage en temps réel par site ou identifiant |
| 📋 Copie rapide | Copie identifiant ou mot de passe en 1 clic |
| 👁️ Affichage | Toggle afficher / masquer le mot de passe |
| 📊 Force | Indicateur visuel Faible → Très fort |
| ⚡ Générateur | Mot de passe aléatoire 16 caractères |
| 🔒 Chiffrement | XOR + Base64 pour les mots de passe stockés |
| 🛡️ Sécurité SQL | Requêtes préparées PDO — anti injection |

---

## 🏗️ Architecture du projet

```
password_manager/
│
├── 📁 Interface/
│   ├── connexion.html       ← Authentification (login + inscription)
│   └── principale.html      ← App principale (liste + détail + modal)
│
├── 📁 serveur/
│   ├── auth.php             ← Sessions : login, logout, vérification
│   ├── connexion_bd.php     ← Connexion PDO à MySQL
│   └── mots_de_passe.php   ← API REST : lire, ajouter, modifier, supprimer
│
├── 📁 donnees/
│   └── base.sql             ← Schéma SQL (tables utilisateurs + mots_de_passe)
│
└── README.md
```

---

## 🚀 Installation

### Prérequis

- PHP **7.4+**
- MySQL / MariaDB **5.7+**
- Apache (XAMPP, Laragon, ou serveur PHP intégré)

---

### 🔧 Configuration base de données

Modifier `serveur/connexion_bd.php` :

```php
$hote    = "localhost";
$bd_nom  = "coffre";
$bd_user = "root";     // ← ton utilisateur MySQL
$bd_pass = "";         // ← ton mot de passe MySQL
```

Puis importer le schéma :

```sql
-- Dans phpMyAdmin ou via terminal MySQL
SOURCE donnees/base.sql;
```

---

## 🔒 Sécurité

| Couche | Mécanisme |
|---|---|
| Mots de passe utilisateurs | `password_hash()` bcrypt — non réversible |
| Mots de passe stockés | Chiffrement XOR + encodage Base64 |
| Sessions | PHP server-side sessions |
| Base de données | Requêtes préparées PDO (anti-injection SQL) |
| Sorties HTML | Échappement `htmlspecialchars` (anti-XSS) |

> ⚠️ **Note** : Pour un déploiement en production, remplacer le chiffrement XOR par **AES-256** via OpenSSL.

---

## 🛠️ Stack technique

```
Frontend   →  HTML5 · CSS3 · JavaScript (Vanilla ES6+)
Backend    →  PHP 8 · PDO
Base de données  →  MySQL
Icônes     →  Font Awesome 6
```

---

## 📌 À améliorer (roadmap)

- [ ] Chiffrement AES-256 côté serveur
- [ ] Export / Import CSV
- [ ] Mode sombre
- [ ] 2FA (double authentification)
- [ ] Déploiement sur serveur VPS

---

## 👤 Auteur

Projet développé dans le cadre d'un apprentissage **PHP full stack** — de la conception de la base de données jusqu'à l'interface utilisateur.

