test:
	./vendor/bin/phpunit tests/

validate-stan:
	./vendor/bin/phpstan analyse app

validate-phpcs:
	./vendor/bin/php-cs-fixer fix app
