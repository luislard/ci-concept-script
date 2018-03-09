# En el build de docker

echo "$BUILD_NAME"
./develop up -d

# En el build del projecto

cd ../ci-concept-docker
./develop composer install
./develop t ./tests
./develop exec -T php sh -c 'find ./src -name "*.php" -print0 | xargs -0 -n1 -P8 php -l'
./develop exec -T php sh -c 'find ./tests -name "*.php" -print0 | xargs -0 -n1 -P8 php -l'
./develop exec -T php sh -c './vendor/bin/phploc src'
