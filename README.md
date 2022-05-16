# Projeto onboarding Objective

## Requisitos necessarios

````
Docker version 20.10.15
````
````
docker-compose version 1.28.0
````

## Como Iniciar o projeto:

````
docker-compose -f .docker/docker-compose.yml up -d

docker exec -it onboradingProject bash

composer install
````

### Como rodar os Testes Unitarios

````
make test
````

### Como rodar o validate

````
validate-stan
make validate-phpcs
````