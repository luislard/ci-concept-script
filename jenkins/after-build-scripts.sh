# En el build de docker

echo "$BUILD_NAME"
./develop up -d

# En el build del projecto

cd ../ci-concept-docker
./develop composer install
./develop t ./tests
