<?php

namespace hexpang\google;

if (file_exists('vendor/simple-html-dom/simple-html-dom/simple_html_dom.php')) {
    require_once 'vendor/simple-html-dom/simple-html-dom/simple_html_dom.php';
} else {
    require_once __DIR__.'/../../../../../simple-html-dom/simple-html-dom/simple_html_dom.php';
}

class Search
{
    public $baseURL;
    public function __construct()
    {
        $this->baseURL = 'https://www.google.com/search?client=safari&q={key}&start={offset}&rls=en&ie=UTF-8&oe=UTF-8';
    }
    public function byKey($keyword, $offset = 0)
    {
        $u = str_ireplace('{offset}', $offset, $this->baseURL);
        $u = str_ireplace('{key}', $keyword, $u);

        $client = new \GuzzleHttp\Client();
        $source = $client->request('GET', $u, ['proxy' => 'http://127.0.0.1:7777']);
        $source = (string) $source->getBody();
        $html = str_get_html($source);
        $result = $html->find('div[class=g]');
        $data = [];
        foreach ($result as $k => $v) {
            $s = $v->find('h3 a');
            if (count($s) > 0) {
                $link = $s[0];
                $title = $link->plaintext;
                $url = $link->href;
                $url = substr($url, stripos($url, '=') + 1);
                $url = substr($url, 0, stripos($url, '&'));
                $data[] = ['title' => $title, 'url' => $url];
            }
        }

        return $data;
    }
}
