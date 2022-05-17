test:
	./vendor/bin/phpunit tests/

validate-stan:
	./vendor/bin/phpstan analyse -l 6 app tests

validate-phpcs:
	./vendor/bin/php-cs-fixer fix app -v --dry-run
