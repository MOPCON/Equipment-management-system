@setup
    require __DIR__ . '/vendor/autoload.php';
    Dotenv\Dotenv::create(__DIR__)->load();
@endsetup

@servers(['web' => [env('SERVER_NAME')]])

@task('production-cms', ['on' => 'web'])
    export NVM_DIR="$HOME/.nvm"
    [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
    [ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"
    cd /home/ems/prod
    sudo -u www-data git fetch origin {{ $branch }}
    sudo -u www-data git checkout {{ $branch }}
    sudo -u www-data git reset --hard origin/{{ $branch }}
    sudo -u www-data composer install --no-plugins --no-scripts
    sudo -u www-data composer install --optimize-autoloader
    sudo -u www-data php artisan migrate --force
    sudo -u www-data php artisan queue:restart
    sudo cp /home/github/prod/app.css /home/ems/prod/public/css/app.css
    sudo cp /home/github/prod/app.js /home/ems/prod/public/js/app.js
    sudo cp /home/github/prod/manifest.js /home/ems/prod/public/js/manifest.js
    sudo cp /home/github/prod/vendor.js /home/ems/prod/public/js/vendor.js
    sudo chown www-data:www-data /home/ems/prod/public/js/app.js /home/ems/prod/public/js/manifest.js /home/ems/prod/public/js/vendor.js /home/ems/prod/public/css/app.css
@endtask

@task('testing-cms', ['on' => 'web'])
    export NVM_DIR="$HOME/.nvm"
    [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
    [ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"
    cd /home/ems/test
    sudo -u www-data git fetch origin {{ $branch }}
    sudo -u www-data git checkout {{ $branch }}
    sudo -u www-data git reset --hard origin/{{ $branch }}
    sudo -u www-data composer install --no-plugins --no-scripts
    sudo -u www-data composer install --optimize-autoloader
    sudo -u www-data php artisan migrate
    sudo -u www-data php artisan queue:restart
    sudo cp /home/github/test/app.css /home/ems/test/public/css/app.css
    sudo cp /home/github/test/app.js /home/ems/test/public/js/app.js
    sudo cp /home/github/test/manifest.js /home/ems/test/public/js/manifest.js
    sudo cp /home/github/test/vendor.js /home/ems/test/public/js/vendor.js
    sudo chown www-data:www-data /home/ems/test/public/js/app.js /home/ems/test/public/js/manifest.js /home/ems/test/public/js/vendor.js /home/ems/test/public/css/app.css
@endtask

@after
    @slack(env('SLACK_HOOK_URL'), env('SLACK_CHANNEL'), "Deploy $task done!")
@endafter
