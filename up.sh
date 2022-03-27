#!/usr/bin/env bash
set -e

realpath() {
    [[ $1 = /* ]] && echo "$1" || echo "$PWD/${1#./}"
}

DOCKERCOMPOSE="docker-compose --file $(dirname $(realpath $0))/docker/docker-compose.yaml --env-file $(dirname $(realpath $0))/docker/.env"

$DOCKERCOMPOSE up -d --remove-orphans
