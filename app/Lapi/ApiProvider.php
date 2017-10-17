<?php

namespace App\Lapi;

use GuzzleHttp;

class ApiProvider
{
    protected $provider;
    protected $url;
    protected $results;

    public function __create() {
    }

    public function apiConfig($name) {
        $this->provider = $name;
        switch ($this->provider) {
            case 'git' : $this->url = 'https://api.github.com/search/code'; break;
        }
    }

    public function makeQuery(QueryProvider $q) {
        $client = new GuzzleHttp\Client();
        $res = $client->get($this->url . '?q=' . $q->getQuery() . '&page=' . $q->getPage() . '&per_page=' . $q->getPagenum(), [
            'auth' => [
                'user',
                'password'
            ]
        ]);
        if ($res->getStatusCode() == 200) {
            $this->results = json_decode($res->getBody());
            dd($this->results);
            return true;
        }
        return false;
    }

    public function results() {
        $filtered = [];
        dd($this->results);
        foreach ($this->results->items as $value) {
            $filtered[] = array(
                'owner name' => $value->repository->owner->login,
                'repository' => $value->repository->url,
                'filename' => $value->name,
                'score' => $value->score);
        }
        return $filtered;
    }
}