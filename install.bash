#!/bin/bash

FILE_ENV=./src/.env
if [ ! -f "$FILE_ENV" ]; then
 FILE_ENV_EXAMPLE=./src/.env.example
 if [ -f "$FILE_ENV_EXAMPLE" ]; then
  echo "cp $FILE_ENV_EXAMPLE $FILE_ENV"
  cp $FILE_ENV_EXAMPLE $FILE_ENV
 fi
fi

function renderAndExecute() {
    echo "> $1"
    $1
}

DOCKER_COMPOSE_COMMAND="docker-compose -f ./docker-staff/docker-compose.yaml"

renderAndExecute "$DOCKER_COMPOSE_COMMAND stop"
# renderAndExecute "$DOCKER_COMPOSE_COMMAND down"
# renderAndExecute "$DOCKER_COMPOSE_COMMAND --env-file=$FILE_ENV build --no-cache"
renderAndExecute "$DOCKER_COMPOSE_COMMAND --env-file=$FILE_ENV up"