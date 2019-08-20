#!/bin/sh

set -eu

cd webapp
npm config set strict-ssl false
npm install --registry=http://nexus.apps.cidadania.gov.br/repository/npm-registry/
npm run build

cd dist
tar zcvf dist.tar.gz *
mv dist.tar.gz ../docker/
