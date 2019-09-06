#!/bin/bash
lines=$(docker images | wc -l | awk '{$1=$1};1')
if [  $lines = 1 ]
then
    echo "   [*] No containers found"
    exit 0
else
    echo "   [*] One or more container found"
fi

echo "   [*] stoping all containers"
#stop all containers:
docker kill $(docker ps -q)

echo "   [*] removing all containers"
#remove all containers
docker rm  $(docker ps -a -q)

echo "   [*] removing all docker images"
#remove all docker images
docker rmi -f $(docker images -q)

echo "   [*] listing images"
docker images
