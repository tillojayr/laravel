launch:
	docker compose up -d

setup:
	docker compose exec app composer install
	docker compose exec app cp .env.example .env
	docker compose exec app php artisan key:generate
	docker compose exec app php artisan db:seed --class=UserSeeder
	docker compose exec app php artisan db:seed --class=ProductSeeder

setup-asset:
	npm install
	npm run dev
