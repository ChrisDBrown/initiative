.PHONY: all tests static mess standards
default: all;

tests:
	vendor/bin/phpunit tests

static:
	vendor/bin/phpstan analyse app

mess:
	vendor/bin/phpmd app text phpmd.xml

standards:
	vendor/bin/phpcs --standard=ruleset.xml app/ -s

all: tests static mess standards
