# SAE 3-01 : Développement d'une application

## Auteurs :

- Cladel Valentin - clad0006
- Simon Baptiste - simo0170
- Sikora Tom - siko0001
- Bourga Camille - bour0087

## Installation/configuration :

### En fin de sprint

En fin de séance, vous devez impérativement synchroniser votre dépôt distant (en ligne de commande ou avec PhpStorm)

- git branch (branche)

- git checkout (branche)

- git commit -m "Message"

- git push --set-upstream origin branche

Ensuite, allez sur gitlab faire une merge request pour votre branche et assignez un camarade à la revue/validation.

### En début de séance

Mettre à jour votre dépôt local :

- cd votre_depôt

- git pull


Ensuite, dans le répertoire de votre projet, vous devez et (ré)installer les composants nécessaires à son fonctionnement :

composer install

Vous devrez également reconfigurer votre accès base de données en redéfinissant le fichier « .env.local »

### Scritps

composer start - lancer le serveur

composer test:cs / fix:cs - verifier/corriger le code

composer db - regénerer des données factices