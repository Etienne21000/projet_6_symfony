# Installation projet 6
## Formation DA php / Symfony

### 1. Récupération du projet sur GitHub
- Créer un dossier pour le projet
- Initialiser Git dans le projet `git init`
- Copier le lien du repository sur GitHub
- lancer la commande `git clone dans le terminal à la racine du projet en ajoutant l'url du repository`
- `git clone https://github.com/Etienne21000/projet_6_symfony.git`

### 2. Base de donnée
- Créer la base de donnée à partir des entités `symfony console make:migration`
- Lancer la migration `symfony console doctrine:migrations:migrate`

### 3. Récupération des fixtures
- Récupérer les fixtures via la commande doctrine `symfony console doctrine:fixtures:load`

