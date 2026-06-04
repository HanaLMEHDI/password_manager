<?php
session_start();
if (!isset($_SESSION["uid"])) {
    header("Location: connexion.php");
    exit;
}
$nom_user = htmlspecialchars($_SESSION["nom"]);
$uid      = (int) $_SESSION["uid"];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffre – Gestionnaire de mots de passe</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #534AB7;
            --primary-light: #EEEDFE;
            --primary-dark: #4039a0;
            --text-dark: #1a1a2e;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --bg: #f8fafc;
            --success: #10b981;
            --danger: #ef4444;
        }

        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }

        body {
            background: var(--bg);
            color: var(--text-dark);
            height: 100vh;
            display: flex;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            overflow: hidden;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            flex-shrink: 0;
            background: #fff;
            border-right: 0.5px solid var(--border);
            display: flex;
            flex-direction: column;
            padding: 20px 12px;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
            padding: 0 6px;
        }

        .logo-icon {
            background: var(--primary);
            color: #fff;
            width: 34px;
            height: 34px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            box-shadow: 0 4px 12px rgba(83,74,183,0.3);
            flex-shrink: 0;
        }

        .logo-text {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 9px 14px;
            color: var(--text-muted);
            font-size: 13.5px;
            font-weight: 500;
            border-radius: 9px;
            cursor: pointer;
            transition: all 0.15s;
            user-select: none;
            list-style: none;
        }

        .nav-item i { 
            width: 16px; 
            text-align: center; 
            font-size: 14px; 
        }

        .nav-item:hover { 
            background: #f1f5f9; 
            color: var(--text-dark); 
        }

        .nav-item.active {
            background: var(--primary-light);
            color: var(--primary);
        }

        .nav-count {
            margin-left: auto;
            font-size: 11px;
            color: #bbb;
            font-weight: 600;
        }

        .nav-item.active .nav-count { 
            color: var(--primary); 
        }

        .sidebar-divider { 
            height: 0.5px; 
            background: var(--border); 
            margin: 12px 0; 
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 12px;
            border-top: 0.5px solid var(--border);
        }

        .avatar-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 8px;
            cursor: pointer;
        }

        .avatar-row:hover { 
            background: #f0f0f4; 
        }

        .avatar-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--primary);
            color: var(--primary-light);
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .avatar-info { 
            flex: 1; 
            min-width: 0; 
        }

        .avatar-nom { 
            font-size: 13px; 
            font-weight: 600; 
            color: var(--text-dark); 
        }

        .avatar-sub { 
            font-size: 11px; 
            color: #999; 
        }

        .btn-logout {
            background: none;
            border: none;
            color: #bbb;
            cursor: pointer;
            font-size: 16px;
            padding: 4px;
            transition: color 0.15s;
        }

        .btn-logout:hover { 
            color: var(--danger); 
        }

        /* MAIN */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: var(--bg);
        }

        .top-bar {
            padding: 16px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            background: #fff;
            border-bottom: 0.5px solid var(--border);
        }

        .search-wrap {
            flex: 1;
            max-width: 480px;
            position: relative;
        }

        .search-wrap i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 14px;
        }

        .search-input {
            width: 100%;
            padding: 10px 14px 10px 38px;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: var(--bg);
            font-size: 13.5px;
            outline: none;
            transition: all 0.2s;
            color: var(--text-dark);
        }

        .search-input:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(83,74,183,0.1);
        }

        .btn-add {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 10px 18px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 7px;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(83,74,183,0.25);
            white-space: nowrap;
        }

        .btn-add:hover { 
            background: var(--primary-dark); 
            transform: translateY(-1px); 
        }

        /* CONTENT */
        .content { 
            flex: 1; 
            display: flex; 
            overflow: hidden; 
        }

        .list-panel {
            flex: 1;
            overflow-y: auto;
            padding: 14px 18px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .section-label {
            font-size: 10.5px;
            font-weight: 700;
            color: #c0c0ca;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            padding: 8px 2px 4px;
        }

        .entry {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            background: #fff;
            border: 0.5px solid #eaeaef;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.15s;
            user-select: none;
        }

        .entry:hover { 
            border-color: #c4c0f0; 
            background: #fafafa; 
        }

        .entry.selected { 
            border-color: #7F77DD; 
            background: var(--primary-light); 
        }

        .entry-icon {
            width: 38px;
            height: 38px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            flex-shrink: 0;
            border: 0.5px solid rgba(0,0,0,0.05);
        }

        .entry-info { 
            flex: 1; 
            min-width: 0; 
        }

        .entry-site { 
            font-size: 13.5px; 
            font-weight: 600; 
            color: var(--text-dark); 
        }

        .entry.selected .entry-site { color: #3C3489; }

        .entry-user {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .entry-btns { 
            display: flex; 
            gap: 2px; 
            opacity: 0; 
            transition: opacity 0.15s; 
        }

        .entry:hover .entry-btns { opacity: 1; }

        .entry-btn {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: none;
            background: transparent;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.15s;
        }

        .entry-btn:hover { background: rgba(83,74,183,0.1); }
        .entry-btn.danger:hover { background: rgba(226,75,74,0.1); }

        .vide {
            text-align: center;
            color: #bbb;
            padding: 60px 0;
            font-size: 13px;
            line-height: 2;
        }

        /* DETAIL */
        .detail-panel {
            width: 320px;
            background: #fff;
            border-left: 0.5px solid var(--border);
            padding: 28px 24px;
            display: flex;
            flex-direction: column;
            gap: 18px;
            overflow-y: auto;
            flex-shrink: 0;
        }

        .detail-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #ccc;
            font-size: 13px;
            text-align: center;
            gap: 10px;
        }

        .detail-icon {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            border: 0.5px solid rgba(0,0,0,0.06);
            margin: 0 auto;
        }

        .detail-site { 
            font-size: 17px; 
            font-weight: 700; 
            color: var(--text-dark); 
            text-align: center; 
            margin-top: 6px; 
        }

        .detail-url { 
            font-size: 12px; 
            color: var(--primary); 
            text-align: center; 
        }

        .divider { 
            height: 0.5px; 
            background: var(--border); 
        }

        .detail-field { 
            display: flex; 
            flex-direction: column; 
            gap: 6px; 
        }

        .detail-label {
            font-size: 10px;
            font-weight: 700;
            color: var(--text-muted);
            letter-spacing: 0.07em;
            text-transform: uppercase;
        }

        .detail-val { 
            font-size: 13px; 
            color: var(--text-dark); 
            word-break: break-all; 
        }

        .detail-pw-row { 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            gap: 8px; 
        }

        .pw-dots { 
            font-size: 10px; 
            letter-spacing: 3px; 
            color: var(--text-dark); 
        }

        .btn-eye {
            background: none; 
            border: none; 
            color: #aaa;
            cursor: pointer; 
            font-size: 15px; 
            padding: 2px; 
            transition: color 0.15s;
        }

        .btn-eye:hover { color: var(--primary); }

        .strength-bar { height: 4px; width: 100%; background: #e2e8f0; border-radius: 2px; overflow: hidden; }
        .strength-fill { height: 100%; background: var(--success); transition: width 0.3s; }
        .strength-text { font-size: 11px; font-weight: 600; }

        .tag {
            align-self: flex-start;
            background: var(--primary-light);
            color: var(--primary);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .btn-copy {
            background: #f8fafc;
            border: 0.5px solid var(--border);
            color: var(--text-muted);
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            padding: 7px 12px;
            border-radius: 7px;
            transition: all 0.15s;
            text-align: left;
        }

        .btn-copy:hover { 
            border-color: var(--primary); 
            color: var(--primary); 
            background: var(--primary-light); 
        }

        .btn-copy.copied { 
            border-color: var(--success); 
            color: var(--success); 
            background: #edf7f2; 
        }

        .detail-actions { 
            display: flex; 
            gap: 8px; 
            margin-top: auto; 
            padding-top: 8px; 
        }

        .btn-modifier {
            flex: 1; 
            padding: 9px;
            background: #fff; 
            color: #555;
            border: 0.5px solid var(--border);
            border-radius: 8px; 
            font-size: 12px; 
            font-weight: 500;
            cursor: pointer; 
            transition: all 0.15s;
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 5px;
        }

        .btn-modifier:hover { 
            border-color: var(--primary); 
            color: var(--primary); 
        }

        .btn-supprimer {
            padding: 9px 13px;
            background: #fff; 
            color: var(--danger);
            border: 0.5px solid var(--border);
            border-radius: 8px; 
            font-size: 13px;
            cursor: pointer; 
            transition: all 0.15s;
        }
        .btn-supprimer:hover { background: #FCEBEB; border-color: var(--danger); }

        /* MODAL */
        .fond-modal {
            display: none; 
            position: fixed; 
            inset: 0;
            background: rgba(0,0,0,0.3); 
            z-index: 100;
            align-items: center; 
            justify-content: center;
        }

        .fond-modal.visible { display: flex; }

        .modal {
            background: #fff;
            border-radius: 14px;
            padding: 28px;
            width: 420px;
            border: 0.5px solid #e8e8ec;
            box-shadow: 0 12px 50px rgba(0,0,0,0.15);
        }

        .modal h2 { 
            font-size: 16px; 
            font-weight: 700; 
            color: var(--text-dark); 
            margin-bottom: 20px; 
        }

        .modal label {
            display: block; 
            font-size: 12px; 
            color: #888;
            margin-top: 14px; 
            margin-bottom: 5px; 
            font-weight: 500;
        }

        .modal input, .modal select {
            width: 100%; 
            padding: 10px 13px;
            background: #fafafa; 
            border: 0.5px solid #e8e8ec;
            border-radius: 8px; 
            color: var(--text-dark);
            font-size: 13px; 
            outline: none; 
            transition: border-color 0.2s;
        }

        .modal input:focus, .modal select:focus {
            border-color: var(--primary); 
            background: #fff;
            box-shadow: 0 0 0 3px rgba(83,74,183,0.08);
        }

        .mdp-row { 
            display: flex; 
            gap: 8px; 
            align-items: flex-end; 
        }

        .mdp-row input { flex: 1; }

        .btn-gen {
            padding: 10px 13px;
            background: var(--primary-light); 
            color: var(--primary);
            border: none; 
            border-radius: 8px;
            font-size: 12px; 
            font-weight: 600;
            cursor: pointer; 
            white-space: nowrap;
            transition: background 0.15s;
        }
        .btn-gen:hover { background: #d5d3f8; }

        .modal-btns { 
            display: flex; 
            gap: 10px; 
            margin-top: 22px; 
        }

        .btn-sauveg {
            flex: 1; 
            padding: 11px;
            background: var(--primary); 
            color: #fff;
            border: none; 
            border-radius: 8px;
            font-size: 13px; 
            font-weight: 700;
            cursor: pointer; 
            transition: background 0.15s;
        }
        .btn-sauveg:hover { background: var(--primary-dark); }

        .btn-cancel {
            padding: 11px 16px;
            background: #f5f5f7; 
            color: #888;
            border: none; 
            border-radius: 8px;
            font-size: 13px; 
            cursor: pointer;
            transition: background 0.15s;
        }
        .btn-cancel:hover { background: #eaeaef; }

        /* TOAST */
        .toast {
            position: fixed;
            bottom: 24px; 
            right: 24px;
            background: #1a1a2e; 
            color: #fff;
            padding: 10px 18px; 
            border-radius: 8px;
            font-size: 13px; 
            font-weight: 500;
            opacity: 0; 
            transform: translateY(8px);
            transition: all 0.25s; 
            pointer-events: none;
            z-index: 999;
        }
        .toast.visible { 
            opacity: 1; 
            transform: translateY(0); 
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="logo-container">
            <div class="logo-icon">
                <i class="fa-solid fa-vault"></i>
            </div>
            <span class="logo-text">Mon Coffre</span>
        </div>

        <nav>
            <ul style="list-style:none; display:flex; flex-direction:column; gap:2px;">
                <li class="nav-item active" data-cat="Tous" onclick="changerCat('Tous')">
                    <i class="fa-solid fa-layer-group"></i> Tous
                    <span class="nav-count" id="count-Tous">0</span>
                </li>
                <li class="nav-item" data-cat="Travail" onclick="changerCat('Travail')">
                    <i class="fa-solid fa-briefcase"></i> Travail
                    <span class="nav-count" id="count-Travail">0</span>
                </li>
                <li class="nav-item" data-cat="Personnel" onclick="changerCat('Personnel')">
                    <i class="fa-solid fa-user"></i> Personnel
                    <span class="nav-count" id="count-Personnel">0</span>
                </li>
                <li class="nav-item" data-cat="Favoris" onclick="changerCat('Favoris')">
                    <i class="fa-solid fa-star"></i> Favoris
                    <span class="nav-count" id="count-Favoris">0</span>
                </li>
            </ul>
        </nav>

        <div class="sidebar-divider"></div>

        <div class="sidebar-bottom">
            <div class="avatar-row">
                <div class="avatar-circle" id="avatar-initiales">?</div>
                <div class="avatar-info">
                    <div class="avatar-nom" id="avatar-nom">—</div>
                    <div class="avatar-sub" id="avatar-sub">0 mots de passe</div>
                </div>
                <button class="btn-logout" onclick="deconnecter()" title="Déconnexion">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </div>
        </div>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div class="search-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="recherche" class="search-input"
                       placeholder="Rechercher un site…" oninput="filtrer()">
            </div>
            <button class="btn-add" onclick="ouvrirModal()">
                <i class="fa-solid fa-plus"></i> Ajouter
            </button>
        </div>

        <div class="content">
            <div class="list-panel" id="list-panel">
                <div class="vide">Chargement…</div>
            </div>

            <aside class="detail-panel" id="detail-panel">
                <div class="detail-empty">
                    <i class="fa-solid fa-lock" style="font-size:36px; color:#ddd;"></i>
                    <div>Sélectionne une entrée<br>pour voir les détails</div>
                </div>
            </aside>
        </div>
    </main>

    <!-- Modal -->
    <div class="fond-modal" id="fond-modal" onclick="fermerSiDehors(event)">
        <div class="modal">
            <h2 id="modal-titre">Ajouter un mot de passe</h2>

            <label>Site / Application *</label>
            <input type="text" id="f-site" placeholder="ex: GitHub">

            <label>URL (optionnel)</label>
            <input type="text" id="f-url" placeholder="ex: github.com">

            <label>Identifiant / Email *</label>
            <input type="text" id="f-ident" placeholder="ex: hana@email.com">

            <label>Mot de passe *</label>
            <div class="mdp-row">
                <input type="password" id="f-mdp" placeholder="••••••••">
                <button class="btn-gen" onclick="genererMdp()">⚡ Générer</button>
            </div>

            <label>Catégorie</label>
            <select id="f-cat">
                <option value="Personnel">Personnel</option>
                <option value="Travail">Travail</option>
                <option value="Favoris">Favoris</option>
            </select>

            <div class="modal-btns">
                <button class="btn-cancel" onclick="fermerModal()">Annuler</button>
                <button class="btn-sauveg" onclick="sauvegarder()">Sauvegarder</button>
            </div>
        </div>
    </div>

    <div class="toast" id="toast"></div>

    <script>
        let toutesEntrees = [];
        let entreeFiltree  = [];
        let catActuelle    = "Tous";
        let entreeSelectee = null;
        let idEnEdition    = null;
        let nomUser        = "";
        let mdpVisible     = false;

        const ICONES = {
            github:    ["<i class='fa-brands fa-github'></i>", "#E6F1FB"],
            gitlab:    ["🦊", "#FAECE7"],
            google:    ["🌐", "#E6F1FB"],
            gmail:     ["📧", "#FAECE7"],
            netflix:   ["🎬", "#FCEBEB"],
            amazon:    ["📦", "#FAEEDA"],
            facebook:  ["📘", "#E6F1FB"],
            instagram: ["📸", "#FBEAF0"],
            twitter:   ["🐦", "#E6F1FB"],
            linkedin:  ["💼", "#E6F1FB"],
            youtube:   ["▶️", "#FCEBEB"],
            spotify:   ["🎵", "#EAF3DE"],
            paypal:    ["💳", "#E6F1FB"],
            discord:   ["🎮", "#EEEDFE"],
            slack:     ["💬", "#FAEEDA"],
        };

        function getIcone(site) {
            const s = site.toLowerCase();
            for (const [k, v] of Object.entries(ICONES))
                if (s.includes(k)) return v;
            return [site.charAt(0).toUpperCase(), "#f0f0f4"];
        }

        function analyserForce(mdp) {
            if (!mdp) return { pct: 0, couleur: "#e8e8ec", texte: "" };
            let score = 0;
            if (mdp.length >= 8) score++;
            if (mdp.length >= 12) score++;
            if (/[A-Z]/.test(mdp)) score++;
            if (/[0-9]/.test(mdp)) score++;
            if (/[^a-zA-Z0-9]/.test(mdp)) score++;
            if (score <= 1) return { pct: 20,  couleur: "#E24B4A", texte: "Faible" };
            if (score <= 2) return { pct: 40,  couleur: "#EF9F27", texte: "Moyen" };
            if (score <= 3) return { pct: 65,  couleur: "#EF9F27", texte: "Correct" };
            if (score <= 4) return { pct: 85,  couleur: "#1D9E75", texte: "Fort" };
            return             { pct: 100, couleur: "#0F6E56", texte: "Très fort" };
        }

        function ech(s) {
            return String(s || "")
                .replace(/&/g,"&amp;").replace(/</g,"&lt;")
                .replace(/>/g,"&gt;").replace(/"/g,"&quot;").replace(/'/g,"&#39;");
        }

        /* Init — nom injecté directement par PHP (session vérifiée server-side) */
        async function init() {
            nomUser = <?php echo json_encode($nom_user); ?>;
            document.getElementById("avatar-nom").textContent = nomUser;
            document.getElementById("avatar-initiales").textContent = nomUser.slice(0,2).toUpperCase();
            await charger();
        }

        /* Charger */
        async function charger() {
            const rep  = await fetch(`../serveur/mots_de_passe.php?action=lire&categorie=${catActuelle}`);
            const json = await rep.json();
            if (!json.ok) { window.location.href = "connexion.html"; return; }

            toutesEntrees = json.donnees;
            entreeFiltree = [...toutesEntrees];
            majCompteurs();
            afficherListe();

            if (entreeSelectee) {
                const e = toutesEntrees.find(x => x.id == entreeSelectee.id);
                if (e) afficherDetail(e); else viderDetail();
            }
        }

        /* Compteurs sidebar */
        async function majCompteurs() {
            const rep  = await fetch("../serveur/mots_de_passe.php?action=lire&categorie=Tous");
            const json = await rep.json();
            if (!json.ok) return;
            const tous = json.donnees;

            ["Tous","Travail","Personnel","Favoris"].forEach(c => {
                const n = c === "Tous" ? tous.length : tous.filter(e => e.categorie === c).length;
                const el = document.getElementById("count-" + c);
                if (el) el.textContent = n || "";
            });
            document.getElementById("avatar-sub").textContent =
                `${tous.length} mot${tous.length > 1 ? "s" : ""} de passe`;
        }

        /* Afficher liste */
        function afficherListe() {
            const panel = document.getElementById("list-panel");

            if (entreeFiltree.length === 0) {
                panel.innerHTML = `<div class="vide">🔍<br>Aucune entrée.<br>Clique sur <strong>+ Ajouter</strong> !</div>`;
                return;
            }

            const maintenant = Date.now();
            const recents = entreeFiltree.filter(e => (maintenant - new Date(e.ajoute_le)) < 7*24*3600*1000);
            const anciens = entreeFiltree.filter(e => (maintenant - new Date(e.ajoute_le)) >= 7*24*3600*1000);

            let html = "";
            if (recents.length) {
                html += `<div class="section-label">Récents</div>`;
                html += recents.map(carteHTML).join("");
            }
            if (anciens.length) {
                html += `<div class="section-label">Plus anciens</div>`;
                html += anciens.map(carteHTML).join("");
            }

            panel.innerHTML = html;

            if (entreeSelectee) {
                const el = panel.querySelector(`[data-id="${entreeSelectee.id}"]`);
                if (el) el.classList.add("selected");
            }
        }

        function carteHTML(e) {
            const [icone, bg] = getIcone(e.site);
            const sel = entreeSelectee && entreeSelectee.id == e.id ? "selected" : "";
            return `
            <div class="entry ${sel}" data-id="${e.id}" onclick="selectionner(${e.id})">
                <div class="entry-icon" style="background:${bg}">${icone}</div>
                <div class="entry-info">
                    <div class="entry-site">${ech(e.site)}</div>
                    <div class="entry-user">${ech(e.identifiant)}</div>
                </div>
                <div class="entry-btns">
                    <button class="entry-btn" onclick="event.stopPropagation(); copier('${ech(e.mot_de_passe)}','Mot de passe copié !')" title="Copier">📋</button>
                    <button class="entry-btn" onclick="event.stopPropagation(); ouvrirModal(${e.id})" title="Modifier">✏️</button>
                    <button class="entry-btn danger" onclick="event.stopPropagation(); supprimer(${e.id})" title="Supprimer">🗑</button>
                </div>
            </div>`;
        }

        function selectionner(id) {
            const e = toutesEntrees.find(x => x.id == id);
            if (!e) return;
            entreeSelectee = e;
            mdpVisible = false;
            document.querySelectorAll(".entry").forEach(el => el.classList.remove("selected"));
            const el = document.querySelector(`[data-id="${id}"]`);
            if (el) el.classList.add("selected");
            afficherDetail(e);
        }

        function afficherDetail(e) {
            const [icone, bg] = getIcone(e.site);
            const force = analyserForce(e.mot_de_passe);
            const coulCat = { Travail:"#E6F1FB", Personnel:"#EEEDFE", Shopping:"#FAEEDA", Favoris:"#FFF0DA" };

            document.getElementById("detail-panel").innerHTML = `
            <div style="text-align:center;">
                <div class="detail-icon" style="background:${bg}">${icone}</div>
                <div class="detail-site">${ech(e.site)}</div>
                <div class="detail-url">${ech(e.url || "—")}</div>
            </div>

            <div class="divider"></div>

            <div class="detail-field">
                <div class="detail-label">Identifiant</div>
                <div class="detail-val">${ech(e.identifiant)}</div>
                <button class="btn-copy" id="btn-copy-ident"
                        onclick="copier('${ech(e.identifiant)}','Identifiant copié !','btn-copy-ident')">
                    📋 Copier l'identifiant
                </button>
            </div>

            <div class="detail-field">
                <div class="detail-label">Mot de passe</div>
                <div class="detail-pw-row">
                    <span class="pw-dots" id="mdp-affiche">●●●●●●●●●●●●</span>
                    <button class="btn-eye" onclick="toggleMdp('${ech(e.mot_de_passe)}')" id="btn-oeil">👁</button>
                </div>
                <div class="strength-bar">
                    <div class="strength-fill" style="width:${force.pct}%; background:${force.couleur}"></div>
                </div>
                <div class="strength-text" style="color:${force.couleur}">${force.texte}</div>
                <button class="btn-copy" id="btn-copy-mdp"
                        onclick="copier('${ech(e.mot_de_passe)}','Mot de passe copié !','btn-copy-mdp')">
                    📋 Copier le mot de passe
                </button>
            </div>

            <div class="divider"></div>

            <div class="detail-field">
                <div class="detail-label">Catégorie</div>
                <span class="tag" style="background:${coulCat[e.categorie]||'#EEEDFE'}">${e.categorie}</span>
            </div>

            <div class="detail-actions">
                <button class="btn-modifier" onclick="ouvrirModal(${e.id})">✏️ Modifier</button>
                <button class="btn-supprimer" onclick="supprimer(${e.id})">🗑</button>
            </div>`;
        }

        function viderDetail() {
            entreeSelectee = null;
            document.getElementById("detail-panel").innerHTML = `
            <div class="detail-empty">
                <i class="fa-solid fa-lock" style="font-size:36px; color:#ddd;"></i>
                <div>Sélectionne une entrée<br>pour voir les détails</div>
            </div>`;
        }

        function toggleMdp(mdp) {
            mdpVisible = !mdpVisible;
            const el = document.getElementById("mdp-affiche");
            const oeil = document.getElementById("btn-oeil");
            if (el) el.textContent = mdpVisible ? mdp : "●●●●●●●●●●●●";
            if (oeil) oeil.textContent = mdpVisible ? "🙈" : "👁";
        }

        function filtrer() {
            const q = document.getElementById("recherche").value.toLowerCase();
            entreeFiltree = toutesEntrees.filter(e =>
                e.site.toLowerCase().includes(q) || e.identifiant.toLowerCase().includes(q)
            );
            afficherListe();
        }

        function changerCat(cat) {
            catActuelle = cat;
            document.querySelectorAll(".nav-item").forEach(el =>
                el.classList.toggle("active", el.dataset.cat === cat)
            );
            document.getElementById("recherche").value = "";
            entreeSelectee = null;
            viderDetail();
            charger();
        }

        function copier(texte, msg="Copié !", btnId=null) {
            navigator.clipboard.writeText(texte).then(() => {
                afficherToast(msg);
                if (btnId) {
                    const btn = document.getElementById(btnId);
                    if (btn) {
                        const orig = btn.textContent;
                        btn.classList.add("copied");
                        btn.textContent = "✅ Copié !";
                        setTimeout(() => { btn.classList.remove("copied"); btn.textContent = orig; }, 2000);
                    }
                }
            });
        }

        function afficherToast(msg) {
            const t = document.getElementById("toast");
            t.textContent = msg;
            t.classList.add("visible");
            setTimeout(() => t.classList.remove("visible"), 2200);
        }

        function ouvrirModal(id=null) {
            idEnEdition = id;
            const e = id ? toutesEntrees.find(x => x.id == id) : null;
            document.getElementById("modal-titre").textContent = id ? "Modifier" : "Ajouter un mot de passe";
            document.getElementById("f-site").value  = e ? e.site : "";
            document.getElementById("f-url").value   = e ? (e.url || "") : "";
            document.getElementById("f-ident").value = e ? e.identifiant : "";
            document.getElementById("f-mdp").value   = e ? e.mot_de_passe : "";
            document.getElementById("f-cat").value   = e ? e.categorie : "Personnel";
            document.getElementById("fond-modal").classList.add("visible");
            document.getElementById("f-site").focus();
        }

        function fermerModal() {
            document.getElementById("fond-modal").classList.remove("visible");
            idEnEdition = null;
        }

        function fermerSiDehors(e) {
            if (e.target === document.getElementById("fond-modal")) fermerModal();
        }

        function genererMdp() {
            const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*";
            let mdp = "";
            for (let i = 0; i < 16; i++) mdp += chars[Math.floor(Math.random() * chars.length)];
            document.getElementById("f-mdp").value = mdp;
        }

        async function sauvegarder() {
            const site  = document.getElementById("f-site").value.trim();
            const ident = document.getElementById("f-ident").value.trim();
            const mdp   = document.getElementById("f-mdp").value;

            if (!site || !ident || !mdp) { afficherToast("⚠️ Remplis les champs obligatoires"); return; }

            const d = new FormData();
            d.append("action", idEnEdition ? "modifier" : "ajouter");
            d.append("site", site);
            d.append("url", document.getElementById("f-url").value.trim());
            d.append("identifiant", ident);
            d.append("mot_de_passe", mdp);
            d.append("categorie", document.getElementById("f-cat").value);
            if (idEnEdition) d.append("id", idEnEdition);

            const rep  = await fetch("../serveur/mots_de_passe.php", { method: "POST", body: d });
            const json = await rep.json();

            if (json.ok) {
                fermerModal();
                afficherToast(idEnEdition ? "✅ Modifié !" : "✅ Ajouté !");
                await charger();
                if (!idEnEdition && toutesEntrees.length > 0) selectionner(toutesEntrees[0].id);
            } else {
                afficherToast("⚠️ " + (json.message || "Erreur"));
            }
        }

        async function supprimer(id) {
            if (!confirm("Supprimer cette entrée ?")) return;
            const d = new FormData();
            d.append("action", "supprimer");
            d.append("id", id);
            const rep  = await fetch("../serveur/mots_de_passe.php", { method: "POST", body: d });
            const json = await rep.json();
            if (json.ok) {
                if (entreeSelectee && entreeSelectee.id == id) viderDetail();
                afficherToast("🗑 Supprimé");
                await charger();
            }
        }

        async function deconnecter() {
            const d = new FormData();
            d.append("action", "deconnexion");
            await fetch("../serveur/auth.php", { method: "POST", body: d });
            window.location.href = "connexion.html";
        }

        init();
    </script>
</body>
</html>
