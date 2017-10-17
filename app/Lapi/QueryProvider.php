<?php

namespace App\Lapi;

use App\Lapi\ApiProvider;

class QueryProvider
{
    protected $apiprovider; // connection to API
    protected $query; // query to pass to API
    protected $page;
    protected $pagenum; // param for number of results per page
    protected $sort;
    protected $results; // store data from apiProvider

    public function __construct(ApiProvider $apiprovider) {
        $this->apiprovider = $apiprovider;
        $this->results = [];
    }

    public function getQuery() {
        return $this->query;
    }

    public function getPage() {
        return $this->page;
    }

    public function getPagenum() {
        return $this->pagenum;
    }

    public function getSort(){
        return $this->sort;
    }

    public function config($api, $request) {
        $this->apiprovider->apiConfig($api);
        $this->query = $request->q;
        if ($request->p){
            $this->page = $request->p;
        } else {
            $this->page = 1;
        }
        if ($request->pn) {
            $this->pagenum = $request->pn;
        } else {
            $this->pagenum = 25;
        }
        if ($request->s) {
            $this->sort = $request->s;
        }
        if ($this->query) {
            return true;
        }
        return false;
    }

    public function makeQuery() {
        if ($this->apiprovider->makeQuery($this)) {
            $this->results = $this->apiprovider->results();
            return true;
        }
        return false;
    }

    public function queryResults() {
        return $this->results;
    }
}