.PHONY: tests

tests: vendor
	php -d zend.assertions=1 -d assert.exception=1 vendor/bin/peridot ./specs

composer.lock: composer.json
	composer install
	touch composer.lock

vendor: composer.json composer.lock
	composer install
	touch vendor
