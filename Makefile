install:
	cp .env.example .env
	touch tokens
	composer install
	yarn
	yarn run mix
	php lemonade services:build
