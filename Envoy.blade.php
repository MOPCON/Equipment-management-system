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
    sudo -u www-data git reset --hard
    sudo -u www-data git pull origin {{ $branch }}
    sudo -u www-data composer install --no-plugins --no-scripts
    sudo -u www-data composer install --optimize-autoloader
    sudo -u www-data yarn install
    sudo -u www-data yarn run prod
    sudo -u www-data php artisan migrate --force
    sudo -u www-data php artisan queue:restart
@endtask

@task('testing-cms', ['on' => 'web'])
    export NVM_DIR="$HOME/.nvm"
    [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
    [ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"
    cd /home/ems/test
    sudo -u www-data git reset --hard
    sudo -u www-data git pull origin {{ $branch }}
    sudo -u www-data composer install --no-plugins --no-scripts
    sudo -u www-data composer install --optimize-autoloader
    sudo -u www-data yarn install
    sudo -u www-data yarn run prod
    sudo -u www-data php artisan migrate
    sudo -u www-data php artisan queue:restart
@endtask

@after
    @slack(env('SLACK_HOOK_URL'), env('SLACK_CHANNEL'), "Deploy $task done!")
@endafter
