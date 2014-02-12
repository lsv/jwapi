#!/bin/bash
DIRS=("coverage" "logs" "documentation" "doc2")

for i in "${DIRS[@]}"
do
    if [ ! -d "build/$i" ]; then
        mkdir -p "build/$i"
    else
        rm -rf "build/$i"
        mkdir -p "build/$i"
    fi
done

./vendor/bin/phpdoc.php -q
./vendor/bin/apigen.php --config ./apigen.neon
./vendor/bin/phpunit -c ./phpunit.dist.xml