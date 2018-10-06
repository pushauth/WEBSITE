@servers(['staging' => 'admin@192.168.0.18'])
@servers(['dc2' => 'admin@...'])


@task('site', ['on' => ['staging']])
cd /home/admin/web/pushauth.io/public_html/
git reset --hard HEAD
git pull "http://..." master
php artisan queue:restart
php artisan clear-compile
php artisan migrate --force
php artisan config:cache

@endtask

@task('dc2', ['on' => ['dc2']])
cd /home/admin/web/pushauth.io/public_html
git reset --hard HEAD
git pull "..." master
php artisan queue:restart
php artisan clear-compile
php artisan migrate --force
php artisan config:cache
@endtask
