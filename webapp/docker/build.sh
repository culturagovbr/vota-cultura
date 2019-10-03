#!/bin/sh

set -eu

cd webapp
npm config set strict-ssl false
npm install
npm run build

cd dist
tar zcvf dist.tar.gz *
mv dist.tar.gz ../docker/