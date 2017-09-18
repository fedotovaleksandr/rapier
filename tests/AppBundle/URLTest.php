<?php

/*
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AppBundle\Test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Tests for dead links.
 */
class URLTest extends WebTestCase
{
    /**
     * @Test
     * @dataProvider provideUrl
     *
     * Test if pages are alive
     *
     * @param string $url Relative page url
     */
    public function testResponseOK(string $url)
    {
        $client = (new TestClient('test', 'test'))->auth();
        $client->request('GET', $url);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @return array
     */
    public function provideUrl(): array
    {
        return [UrlSet::getUrls()];
    }
}
