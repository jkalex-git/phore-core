<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 27.11.19
 * Time: 17:45
 */

namespace Test;


use PHPUnit\Framework\TestCase;

class ParseUrlTest extends TestCase
{


    public function testParseUrl()
    {
        $url = phore_parse_url("http://user:pass@host:80/path?query#fragment");

        $this->assertEquals("http", $url->scheme);
        $this->assertEquals("host", $url->host);
        $this->assertEquals("80", $url->port);
        $this->assertEquals("/path", $url->path);
        $this->assertEquals("user", $url->user);
        $this->assertEquals("pass", $url->pass);
        $this->assertEquals("query", $url->query);
        $this->assertEquals("fragment", $url->fragment);
    }


    public function testDefaultUrl()
    {
        $url = phore_parse_url("https://host/path", "http://hostdef:80/pathdef");

        $this->assertEquals("https", $url->scheme);
        $this->assertEquals("host", $url->host);
        $this->assertEquals("80", $url->port);
        $this->assertEquals("/path", $url->path);
    }

    public function testQueryString()
    {
        $url = phore_parse_url("https://host/path", "http://hostdef:80?key=val");

        $this->assertEquals(["key"=>"val"], $url->getQueryVal());
        $this->assertEquals("val", $url->getQueryVal("key"));
        $this->assertEquals("def", $url->getQueryVal("nonKey", "def"));

    }
    public function testQueryStringWithEmptyQuery()
    {
        $url = phore_parse_url("https://host/path", "http://hostdef:80");

        $this->assertEquals([], $url->getQueryVal());
        $this->assertEquals("def", $url->getQueryVal("nonKey", "def"));

    }

    public function testPathBeginningWithSlash()
    {
        $url = phore_parse_url("file:///path/to/file.txt");
        $this->assertEquals("/path/to/file.txt", $url->path);
    }
}
