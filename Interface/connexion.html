<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffre – Connexion</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: #f5f5f7;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .carte {
            background: #fff;
            border-radius: 16px;
            border: 0.5px solid #e0e0e0;
            padding: 40px;
            width: 380px;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.06);
        }

        .logo-box {
            width: 44px;
            height: 44px;
            background: #534AB7;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            box-shadow: 0 4px 14px rgba(83, 74, 183, 0.35);
        }

        .logo-box svg {
            width: 22px;
            height: 22px;
            fill: #EEEDFE;
        }

        h1 {
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 4px;
        }

        .sous {
            text-align: center;
            font-size: 13px;
            color: #888;
            margin-bottom: 28px;
        }

        .onglets {
            display: flex;
            background: #f0f0f4;
            border-radius: 8px;
            padding: 3px;
            margin-bottom: 24px;
        }

        .onglet {
            flex: 1;
            padding: 8px;
            text-align: center;
            border-radius: 6px;
            border: none;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            background: transparent;
            color: #888;
            transition: all 0.2s;
        }

        .onglet.actif {
            background: #fff;
            color: #534AB7;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
        }

        label {
            display: block;
            font-size: 12px;
            color: #666;
            margin-bottom: 6px;
            margin-top: 14px;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 11px 14px;
            background: #fafafa;
            border: 0.5px solid #e0e0e0;
            border-radius: 8px;
            color: #1a1a2e;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }

        input:focus {
            border-color: #534AB7;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(83, 74, 183, 0.1);
        }

        .btn {
            width: 100%;
            padding: 12px;
            margin-top: 22px;
            background: #534AB7;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn:hover {
            background: #6c63ff;
        }

        .msg {
            text-align: center;
            margin-top: 12px;
            font-size: 12px;
            min-height: 16px;
        }

        .err {
            color: #e24b4a;
        }

        .ok {
            color: #1D9E75;
        }
    </style>
</head>

<body>

    <div class="carte">
        <div class="logo-box">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12 1C8.676 1 6 3.676 6 7v1H4a1 1 0 0 0-1 1v13a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1h-2V7c0-3.324-2.676-6-6-6zm0 2c2.276 0 4 1.724 4 4v1H8V7c0-2.276 1.724-4 4-4zm0 9a2 2 0 1 1 0 4 2 2 0 0 1 0-4z" />
            </svg>
        </div>
        <h1>Coffre</h1>
        <p class="sous">Gestionnaire de mots de passe</p>

        <div class="onglets">
            <button class="onglet actif" onclick="changerOnglet('connexion')">Connexion</button>
            <button class="onglet" onclick="changerOnglet('inscription')">Inscription</button>
        </div>

        <div>
            <label>Nom d'utilisateur</label>
            <input type="text" id="nom" placeholder="Ton nom…">

            <label>Mot de passe maître</label>
            <input type="password" id="mdp" placeholder="••••••••" onkeydown="if(event.key==='Enter') soumettre()">

            <button class="btn" onclick="soumettre()">Entrer</button>
            <p class="msg" id="msg"></p>
        </div>
    </div>

    <script>
        let mode = "connexion";

        function changerOnglet(m) {
            mode = m;
            document.querySelectorAll(".onglet").forEach((b, i) => {
                b.classList.toggle("actif", (i === 0) === (m === "connexion"));
            });
            document.getElementById("msg").textContent = "";
        }

        async function soumettre() {
            const nom = document.getElementById("nom").value.trim();
            const mdp = document.getElementById("mdp").value;
            const msg = document.getElementById("msg");

            if (!nom || !mdp) { msg.className = "msg err"; msg.textContent = "Remplis tous les champs"; return; }

            const d = new FormData();
            d.append("action", mode);
            d.append("nom", nom);
            d.append("mot_de_passe", mdp);

            try {
                const rep = await fetch("../serveur/auth.php", { method: "POST", body: d });
                const json = await rep.json();

                if (json.ok) {
                    if (mode === "connexion") window.location.href = "principale.html";
                    else { msg.className = "msg ok"; msg.textContent = "Compte créé ! Tu peux te connecter."; changerOnglet("connexion"); }
                } else {
                    msg.className = "msg err"; msg.textContent = json.message;
                }
            } catch (e) {
                msg.className = "msg err"; msg.textContent = "Erreur de connexion au serveur.";
            }
        }
    </script>
</body>

</html>