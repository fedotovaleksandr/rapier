<?php

require_once 'app/autoload.php';

try {
    $kernel = new AppKernel('test', false);
    $kernel->boot();

    if (null == $kernel->getContainer()->get('doctrine')->getRepository('\AppBundle\Entity\User')->findByEmail('test@example.com')) {
        shell_exec('php bin/console fos:user:create test test@example.com test');
    }

    shell_exec('php bin/console fos:user:activate test');
    shell_exec('php bin/console fos:user:promote test ROLE_ADMIN');
} finally {
    $kernel->shutdown();
    register_shutdown_function(function () {
        shell_exec('php bin/console fos:user:deactivate test');
        shell_exec('php bin/console fos:user:demote test ROLE_ADMIN');
    });
}
