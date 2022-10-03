set -e

echo "Deploying application..."

(php artisan down --message 'Updating please wait')

git pull origin master

php artisan up

echo "Application deployed"