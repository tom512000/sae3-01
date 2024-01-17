# SAE 3-01 : Développement d'une application

## 👥 Auteurs

- 👤 Valentin CLADEL - <span style="color: purple">clad0006</span>
- 👤 Baptiste SIMON - <span style="color: purple">simo0170</span>
- 👤 Tom SIKORA - <span style="color: purple">siko0001</span>
- 👤 Camille BOURGA - <span style="color: purple">bour0087</span>

## 📝 Notes
- Identifiant : `pc-client-sae3-01`
- Mot de passe : `pc-client`
- Adresse IP : `10.31.33.47`
- Site : http://10.31.33.47/

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

## 💻 Création de la VM
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
```bash
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

## 🧰 Création du serveur Apache
### 1) Gestion des services : `systemd`
1. `sudo apt-get install openssh-server` : Installation du paquet sshd.
2. `ssh localhost` : Vérification du démarrage du service sshd.
3. `exit` : Déconnexion.
4. `sudo systemctl stop ssh` : Arrêt du service sshd.
5. `ssh localhost` : Reconnexion.
6. `sudo systemctl start ssh` : Redémarrage du service sshd.

### 2) Serveur Web apache2
1. `sudo apt-get install apache2` : Installation du paquet apache2.
2. `sudo apt-get upgrade` : Mise à jour de tous les paquets installés sur le système.
3. `sudo apt-get update` : Mise à jour des informations de dépôt de paquets sur le système.
4. `sudo service apache2 start` : Démarrage du service apache2.
5. Vérification du bon fonctionnement du serveur Web (http://localhost/).
6. `sudo a2enmod userdir` : Activation des pages d'accueil des utilisateurs à l'aide du module userdir.
7. `sudo service apache2 restart` : Redémarrage du service apache2.
8. `git clone https://iut-info.univ-reims.fr/gitlab/clad0006/sae3-01.git` : Clonage du dépôt git de notre projet dans le répertoire d’accueil de l'utilisateur.
9. `sudo chown www-data:www-data ~/sae3-01` : Attribution des droits d’accès à l’utilisateur du serveur Web www-data pour le répertoire sae3-01.
10. `sudo chmod 755 ~/sae3-01` : Affectation des droits par défaut pour le répertoire sae3-01.
11. `sudo ln -s $HOME/sae3-01 /var/www` : Création d'un lien symbolique de notre projet vers l'arborescence /var/www.
12. `nslookup 10.31.33.47` : Récupération du nom DNS de notre machine virtuelle.
13. `sudo evim /etc/hosts` : Modification du fichier /etc/hosts.
    ```bash
    127.0.0.1    localhost
    127.0.0.1    2A4V3-31UVM0303.ad-urca.univ-reims.fr
    
    # The following lines are desirable for IPv6 capable hosts
    ::1     ip6-localhost ip6-loopback
    fe00::0 ip6-localnet
    ff00::0 ip6-mcastprefix
    ff02::1 ip6-allnodes
    ff02::2 ip6-allrouters
    ```
14. `sudo touch /etc/apache2/sites-available/pc-client-sae3-01.conf` : Création du fichier de configuration du serveur.
15. `sudo evim /etc/apache2/sites-available/pc-client-sae3-01.conf` : Modification du fichier de configuration pc-client-sae3-01.conf.
    ```bash
    <VirtualHost *:80>
        ServerName http://2A4V3-31UVM0303.ad-urca.univ-reims.fr
            ServerAdmin webmaster@localhost
        DocumentRoot /var/www/sae3-01/public
    
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
    
        <Directory /var/www/sae3-01>
            Options FollowSymLinks MultiViews
                    AllowOverride None
                    Order allow,deny
                    allow from all
            </Directory>
    </VirtualHost>
    ```
16. `sudo a2ensite /etc/apache2/sites-available/pc-client-sae3-01.conf` : Activation du site.
17. `sudo evim /etc/apache2/sites-available/000-default.conf` : Modification du fichier de configuration par défaut.
    ```bash
        <VirtualHost *:80>
            ServerAdmin webmaster@localhost
            DocumentRoot /var/www/html
        
            <Directory /var/www/html>
                    Options FollowSymLinks
                    AllowOverride None
                    Require all granted
            </Directory>
        
            ErrorLog ${APACHE_LOG_DIR}/error.log
            CustomLog ${APACHE_LOG_DIR}/access.log combined
    </VirtualHost>
    ```
18. `sudo touch /etc/apache2/conf-available/serveur.conf` : Création d'un fichier de configuration du serveur.
19. `sudo evim /etc/apache2/conf-available/serveur.conf` : Modification du fichier de configuration du serveur.
    ```bash
    <Directory /var/www/sae3-01/public>
        Options Indexes FollowSymLinks
        AllowOverride None
        DirectoryIndex /sae3-01/index.php
        FallbackResource /sae3-01/index.php
    </Directory>
    Alias "/sae3-01" "/var/www/sae3-01/public"
    ```
20. `sudo a2enconf /etc/apache2/conf-available/serveur.conf` : Activation de la configuration.
21. `sudo apache2ctl configtest` : Vérification des configurations "Syntax OK".

### 3) Langage de programmation PHP
1. `sudo apt-get install php` : Installation du paquet php.
2. `sudo apt-get install libapache2-mod-php` : Installation du paquet libapache2-mod-php.
3. `sudo evim /etc/apache2/mods-enabled/php8.3.conf` : Modification du fichier php8.3.conf.
    ```bash
    ...
    # <IfModule mod_userdir.c>
    #     <Directory /home/*/public_html>
    #         php_admin_flag engine Off
    #     </Directory>
    # </IfModule>
    ```
4. `sudo service apache2 restart` : Redémarrage du serveur.
5. Vérification de l'accès à la page du site (http://10.31.33.47).

## 📋 Autres
Les fichiers suivants sont disponibles dans le dossier « files » :
1. Cahier des charges au format PDF.
2. Présentation de notre base de données au format PDF.
3. Rapport d'analyse et de conception au format PDF.
4. PowerPoint de l'oral du projet au format PPTX.
5. Démonstration du site au format MP4.
6. Fichier d'accès à la VM au format VV.
