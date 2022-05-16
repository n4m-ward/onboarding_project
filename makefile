test:
	./vendor/bin/phpunit app/tests

validate-stan:
	./vendor/bin/phpstan analyse app

validate-phpcs:
	./vendor/bin/php-cs-fixer fix app