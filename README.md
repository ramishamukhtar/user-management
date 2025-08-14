# user-management
PREREQUISITES:

Make sure you have the following installed:
->Docker installed and running
->Docker Compose installed
->Git installed

CLONE THE REPOSITORY:
git clone https://github.com/ramishamukhtar/user-management.git
cd your-repo

START CONTAINERS:

Windows (PowerShell or CMD):    docker-compose up -d
Linux / macOS:                  docker compose up -d


RUN MIGRATIONS & SEEDS (inside PHP container):
Run inside the PHP container:
docker-compose exec php php yii migrate

ACCESS THE APPLICATION:
Frontend: http://localhost:8080/



