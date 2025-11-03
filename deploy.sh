#!/bin/bash

docker build -f docker/production/Dockerfile -t coolify-custom:dev .
bash /data/coolify/source/upgrade2.sh