install:
	cp .env.example .env
	cp .tokens.example .tokens
	composer install
	yarn
	yarn run mix
