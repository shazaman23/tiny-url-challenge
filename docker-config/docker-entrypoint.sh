#!/bin/bash
set -Eeo pipefail

# Install composer packages 
# (doing so here to avoid including composer packages in docker image layers)
composer install

# Prepare environment
cp .env.example .env
NEWKEY=$(php artisan key:generate --show)
sed -i "s|APP_KEY=|APP_KEY=$NEWKEY|" .env
php artisan migrate
php artisan config:cache

# Update to a viable version of node
# (The base image is based on buster slim and uses an old node version that isn't compatible with laravel npm commands)
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.35.3/install.sh | bash
. ~/.nvm/nvm.sh
nvm install node
export NVM_DIR="$HOME/.nvm"

# Generate project assets
npm install
npm run prod


exec "$@"