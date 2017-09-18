<?php

namespace AppBundle\Test;


use AppKernel;
use Symfony\Component\HttpKernel\Client;

class TestClient
{
    /** @var  Client */
    private static $client;
    private $username;
    private $password;

    /**
     * TestClient constructor.
     *
     * @param $username
     * @param $password
     */
    public function __construct($username = 'test', $password = 'test')
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function auth()
    {
        if (self::$client == null) {
            self::$client = $this->client();
        }

        return self::$client;
    }

    private function client()
    {
        $kernel = new AppKernel('test', false);
        $kernel->boot();
        $client = $kernel->getContainer()->get('test.client');
        $crawler = $client->request('GET', '/login');
        $form = $crawler->filter('form')->form(array(
            '_username' => $this->username,
            '_password' => $this->password,
        ));
        $client->submit($form);
        $client->followRedirect();

        return $client;
    }

    public function logout()
    {
        self::$client->request('GET', '/logout');
        self::$client->followRedirect();
        self::$client = null;
    }
}