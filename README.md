## How to run the app

1. git clone https://github.com/deviam-org/openbrewerydb-frontend.git

2. composer install

3. cp .env.example .env

4. sail up -d

5. sail artisan key:generate

6. sail npm install && sail npm run build

7. start the backend container (read doc at https://github.com/deviam-org/openbrewerydb-backend)

7. open your browser and login with default credentials


## Default Credentials

- Email: root@example.com
- Password: password