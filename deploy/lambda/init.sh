#!/bin/bash
FILES=Makefile,serverless-core.sh

USERNAME=$(aws secretsmanager get-secret-value --secret-id bitbucket-auth | jq --raw-output '.SecretString' | jq -r .USERNAME)
PASSWORD=$(aws secretsmanager get-secret-value --secret-id bitbucket-auth | jq --raw-output '.SecretString' | jq -r .PASSWORD)

IFS=$',' read -ra FILE <<< "${FILES}"
for i in "${FILE[@]}"; do
    if [ -f "$i" ]; then
        rm ${i}*
    fi
    wget https://${USERNAME}:${PASSWORD}@bitbucket.org/jojocoders/serverless-core/raw/master/${i}
done
