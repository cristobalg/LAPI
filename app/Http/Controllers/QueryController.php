<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lapi\QueryProvider;

class QueryController extends Controller
{
    protected $queryprovider;

    public function __construct(QueryProvider $queryprovider) {
        $this->queryprovider = $queryprovider;
    }

    public function query() {
        if ($this->queryprovider->config('git', request())) {
            if ($this->queryprovider->makeQuery()) {
                return response()->json($this->queryprovider->queryResults());
            }
        }
        return response()->json([]);
    }
}
