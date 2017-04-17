<?php

namespace Numa\DOASiteBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertTrue($crawler->filter('html:contains("Search By Body Style")')->count() > 0);
    }

    public function testLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user/login');

        $this->assertTrue($crawler->filter('html:contains("Sign In")')->count() > 0);
    }

    public function testLoginForm()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/user/login');
        $form = $crawler->selectButton('Sign in')->form();
        $form['_username'] = 'Lucas';
        $form['_password'] = 'Hey there!';
        $crawler = $client->submit($form);
        dump($crawler);die();
        $this->assertTrue($crawler->filter('html:contains("Sign In")')->count() > 0);
    }

}
