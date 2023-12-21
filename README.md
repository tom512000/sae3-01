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

### Scripts
- `composer start` : Lance le serveur web de test.
- `composer stop` : Arrête le serveur web de test.
- `composer test:cs` : Lance la commande de vérification du code par PHP CS Fixer.
- `composer fix:cs` : Lance la commande de correction du code par PHP CS Fixer.
- `composer test:codeception` : Nettoie le répertoire « _output » et le code généré par Codeception, initialise la base de données de test et lance les tests de Codeception.
- `composer test` : Teste la mise en forme du code et lance les tests avec Codeception.
- `composer db` : Détruit et recrée la base de données, migre sa structure et regénère les données factices.

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