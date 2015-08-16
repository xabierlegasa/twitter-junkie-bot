# notice that vendor and tests/reports folders are gitignored

vendor/bin/phpunit --colors -c tests/Unit/phpunit.xml --coverage-html tests/reports/coverage tests/Unit
