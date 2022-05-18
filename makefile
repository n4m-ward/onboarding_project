test:
	./vendor/bin/phpunit tests/

validate-stan:
	./vendor/bin/phpstan analyse --level=max app tests

validate-phpcs:
	./vendor/bin/php-cs-fixer fix app -v --dry-run

insight:
    ./vendor/bin/phpinsights