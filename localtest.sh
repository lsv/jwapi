#!/bin/bash
DIRS=("coverage" "logs" "documentation")

for i in "${DIRS[@]}"
do
    if [ ! -d "build/$i" ]; then
        mkdir -p "build/$i"
    else
        rm -rf "build/$i"
        mkdir -p "build/$i"
    fi
done

echo ""
echo ""
echo Starting unit test!
echo ""
echo ""
vendor/bin/phpunit -c ./phpunit.dist.xml