# SAE 3-01 : Développement d'une application

## 👥 Auteurs

- 👤 Valentin CLADEL - <span style="color: purple">clad0006</span>
- 👤 Baptiste SIMON - <span style="color: purple">simo0170</span>
- 👤 Tom SIKORA - <span style="color: purple">siko0001</span>
- 👤 Camille BOURGA - <span style="color: purple">bour0087</span>

## 🛠 Installation et Configuration
### *<span style="color: orange">1. Installation</span>*

Mettre à jour votre dépôt local :
- `git clone https://iut-info.univ-reims.fr/gitlab/clad0006/sae3-01.git`
- `cd <dépôt_local>`
- `git pull`

Ensuite, dans le répertoire de votre projet, vous devez <span style="color: orange">installer les composants nécessaires</span> au fonctionnement du projet :
- `composer install`

Finalement, <span style="color: orange">reconfigurez votre accès à la base de données</span> en redéfinissant le fichier « .env.local » :
- `"DATABASE_URL="mysql://clad0006:clad0006@mysql:3306/clad0006_sae3?serverVersion=mariadb-10.2.25&charset=utf8"`

### *<span style="color: green">2. Instructions de push</span>*

Lorsque vous avez terminé une tâche, <span style="color: green">resynchronisez votre dépôt distant</span> (Invite de commandes ou PhpStorm) :

- `git branch <branche>`
- `git checkout <branche>`
- `git commit -m "message-commit"`
- `git push --set-upstream origin <branche>`

Ensuite, sur GitLab, <span style="color: green">creez une merge-request</span> sur votre branche et <span style="color: green">assignez un camarade</span> à la revue et à la validation.

### *<span style="color: red">3. Site et navigation</span>*

Pour lancer le site, assurez vous d'être <span style="color: red">connecté au VPN</span>.
Ensuite, lancez la commande suivante dans votre terminal :

- `composer start` : Lance le serveur web de test.

Accedez à l'url du site : <span style="color: red">127.0.0.1:8000/</span>. Tant que vous ne vous connectez pas, vous ne pourrez acceder qu'a la page d'accueil.
Si vous tentez de naviguer autre part, vous serez redirigés vers <span style="color: red">le formulaire de connexion</span>.

Depuis ce formulaire, vous pouvez vous connecter :
- `adresse mail` : rentrez une adresse mail valide parmis les comptes disponibles.
- `mot de passe` : rentrez un mot de passe valide parmis les comptes disponibles. (<span style="color: red">'test' pour tous les comptes créés par la factory</span>)
- `compte admin` : compte administrateur de test, email : <span style="color: red">valentin.cladel@gmail.com</span>, mdp : <span style="color: red">test</span>

Vous pouvez également vous inscrire :
- Cliquer sur le lien 'S'inscrire' pour accéder à la page
- Remplissez les informations
- Cliquer sur valider pour créer le compte et l'enregistrer dans la base
- Vous pouvez désormais vous y connecter

Une fois connecté, vous avez accès au site et pouvez consulter offres, entreprises, vous inscrire ou desinscrire a des offres etc.
Vous pouvez également accéder à la section 'Mon Compte' depuis la barre de navigation pour accéder a votre profil puis a sa modification, a vos inscriptions, et si vous êtes connecté en temps qu'admin, au <span style="color: red">dashboard admin</span>.

Pour accéder a la page d'accueil depuis une autre page, il vous suffit de cliquer sur le logo <span style="color: red">EduTech</span> dans la barre de navigation et vous serez redirigés.

## 📐 Scripts
- `composer start` : Lance le serveur web de test.
- `composer stop` : Arrête le serveur web de test.
- `composer test:cs` : Lance la commande de vérification du code par PHP CS Fixer.
- `composer fix:cs` : Lance la commande de correction du code par PHP CS Fixer.
- `composer test:codeception` : Nettoie le répertoire « _output » et le code généré par Codeception, initialise la base de données de test et lance les tests de Codeception.
- `composer test` : Teste la mise en forme du code et lance les tests avec Codeception.
- `composer db` : Détruit et recrée la base de données, migre sa structure et regénère les données factices.

## Création de la VM
### 1) Création de votre machine virtuelle dans OpenNebula
1. Accès à l'interface Web du cloud [OpenNebula](http://one-frontend:9869/).
2. Connexion avec notre compte universitaire pour accéder à notre tableau de bord.
3. Ajout d'une nouvelle machine virtuelle.
4. Choix du modèle "template".
5. Sélection du modèle "TP Install Ubuntu".
6. Saisie du nom de la machine "VM-SAE3-01" avec une taille de disque dur de 25GB.
7. Le second lecteur de notre machine virtuelle permet de selectionner la taille de l'image ISO du DVD de Fedora.
8. Le bouton "Create" permer de créer et lancer le déploiement de la machine virtuelle.
9. Le voyant orange montre que la machine virtuelle est en cours de déploiement, selection du nom de la machine virtuelle.
10. Affichage des détails de notre machine virtuelle qui indiquent son stade de déploiement.
11. Attendre le déploiement complet de la machine virtuelle ("RUNNING" ou voyant vert).
12. Sélection du boutton d'affichage de la machine virtuelle.
13. Lancement de l'installation de la distribution Ubuntu.
14. Augmentation de la résolution de l'écran virtuel et poursuite de l'installation.
15. Commencement de l'installation de notre distribution Linux.

### 2) Utilisation de « Remote Viewer » pour accéder à votre machine virtuelle OpenNebula
1. Téléchargement de la machine vituelle.
2. Lancement de la machine virtuelle en format **.vv**
   - Soit en double-cliquant sur le fichier "VM-SAE3-01.vv".
   - Soit dans un terminal avec la commande :
```HTTP
$ remote-viewer repertoire/ou/est/rangé/le/fichier/VM-SAE3-01.vv
```

### 3) Installation d'une distribution Xubuntu
1. Choix de lancer la distribution en live CD ou de démarrer directement l'installation.
2. Sélection de "Français" puis sélection d'"Installer Xubuntu".
3. Sélection de la disposition du clavier en "French".
4. Désactivation des mises à jour pendant l'installation.

### 4) Configuration des partitions de stockage
1. Choix du type d’installation afin d'organiser notre disque dur pour accueillir le système d’exploitation Ubuntu.
2. Sélection de "Nouvelle table de partition".
3. Confirmation et initialisation du système de partitionnement du disque.
4. Création des partitions :
   - Partie 1 : Taille 500 Mo, primaire, système de fichiers "ext4" et un montage en /boot.
   - Partie 2 : Taille 1500 Mo, primaire, utilisé comme "espace d’échange" et un montage en swap.
   - Partie 3 : Taille 15000 Mo, type logique, système de fichier "ext4" et un montage en /.
   - Partie 4 : Taille espace restant, type logique, système de fichier "ext4" et un montage en /home.
5. Validation de notre système de partitionnement.
6. Choix de notre fuseau horaire à Paris.
7. Renseignement des informations de l'utilisateur de notre système :
   - Nom : pcclientsae301-KVM
   - Nom de notre ordinateur : pc-client-sae3-01
   - Nom d'utilisateur : pc-client-sae3-01
   - Mot de passe : pc-client
8. Démarrage de l'installation.
9. Sélection de "Redémarrer maintenant".
10. Sélection de la touche "Entrer".
11. Redémarrage de la machine virtuelle sur Xunbuntu.
12. Première connexion.

## 📋 Autres
Les fichiers suivants sont disponibles dans le dossier « files » :
1. Cahier des charges au format PDF.
2. Présentation de notre base de données au format PDF.
3. Rapport d'analyse et de conception au format PDF.
4. PowerPoint de l'oral du projet au format PPTX.
5. Démonstration du site au format MP4.
6. Fichier d'accès à la VM au format VV.
