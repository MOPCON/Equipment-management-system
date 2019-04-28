@servers(['web' => ['gcp.puckwang.com']])

@task('deploy_prod', ['on' => 'web'])
    export NVM_DIR="$HOME/.nvm"
    [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
    [ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"
    cd /home/ems/prod
    php artisan down
    sudo git reset --hard
    sudo git pull
    sudo composer install --no-plugins --no-scripts
    sudo composer install --optimize-autoloader
    yarn install
    yarn run prod
    php artisan migrate
    php artisan queue:restart
    php artisan up
@endtask

@task('deploy_test', ['on' => 'web'])
    export NVM_DIR="$HOME/.nvm"
    [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
    [ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"
    cd /home/ems/test
    php artisan down
    sudo git reset --hard
    sudo git pull
    sudo composer install --no-plugins --no-scripts
    sudo composer install --optimize-autoloader
    yarn install
    yarn run prod
    php artisan migrate
    php artisan queue:restart
    php artisan up
@endtask

