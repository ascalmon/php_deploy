<?php
namespace Deployer;

require 'recipe/common.php';

// Project name
set('application', 'my_project');

// Project repository
set('repository', 'git@github.com:ascalmon/php_deploy.git');
add('shared_files', []);
add('shared_dirs', ['www']);
// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
//set('shared_files', []);
//set('shared_dirs', []);

// Writable dirs by web server
set('writable_dirs', []);


// Hosts

//host('project.com')
    //->set('deploy_path', '~/{{application}}');
host('ftp.dionimports.com')
    ->user('dionimports.com')
    ->port(9922)
    //->configFile('~/.ssh/config')
    ->identityFile('~/.ssh/id_rsa')
    ->forwardAgent(true)
    ->multiplexing(true)
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no')
    ->stage('stage')
    ->set('deploy_path', '/var/www/html');

// Tasks

desc('Deploy your project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

task('test', function () {
    writeln('Hello world');
});

task('lsla', function () {
    $result = run('ls -la');
    writeln("Current dir: $result");
});

task('rmdir', function () {
    $result = run('rm -rf /var/www/html');
    writeln("Current dir: $result");
});

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
