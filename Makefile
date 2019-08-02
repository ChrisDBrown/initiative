.PHONY: all tests static
default: all;

tests:
	vendor/bin/phpunit tests

static:
	vendor/bin/phpstan analyse app

all: tests static
