# SAE 3-01 : Développement d'une application

## 👥 Auteurs

- 👤 Valentin CLADEL - <span style="color: purple">clad0006</span>
- 👤 Baptiste SIMON - <span style="color: purple">simo0170</span>
- 👤 Tom SIKORA - <span style="color: purple">siko0001</span>
- 👤 Camille BOURGA - <span style="color: purple">bour0087</span>

## 🛠 Installation et Configuration
### *<span style="color: orange">1. En début de séance</span>*

Mettre à jour votre dépôt local :
- `cd <dépôt_local>`
- `git pull`

Ensuite, dans le répertoire de votre projet, vous devez <span style="color: orange">installer les composants nécessaires</span> au fonctionnement du projet :
- `composer install`

Finalement, <span style="color: orange">reconfigurez votre accès à la base de données</span> en redéfinissant le fichier « .env.local » :
- `DATABASE_URL="mysql://identifiant:mot-de-passe@service:port/nom-bdd?serverVersion=mariadb-10.2.25&charset=utf8"`

### *<span style="color: green">2. En fin de séance</span>*

En fin de séance, <span style="color: green">resynchronisez votre dépôt distant</span> (Invite de commandes ou PhpStorm) :

- `git branch <branche>`
- `git checkout <branche>`
- `git commit -m "message-commit"`
- `git push --set-upstream origin <branche>`

Ensuite, sur GitLab, <span style="color: green">acceptez le merge-request</span> sur votre branche et <span style="color: green">assignez un camarade</span> à la revue et à la validation.

### Scripts
- `composer start` : Lance le serveur web de test.
- `composer test:cs` : Lance la commande de vérification du code par PHP CS Fixer.
- `composer fix:cs` : Lance la commande de correction du code par PHP CS Fixer.
- `composer test:codeception` : Nettoie le répertoire « _output » et le code généré par Codeception, initialise la base de données de test et lance les tests de Codeception.
- `composer test` : Teste la mise en forme du code et lance les tests avec Codeception.
- `composer db` : Détruit et recrée la base de données, migre sa structure et regénère les données factices.
