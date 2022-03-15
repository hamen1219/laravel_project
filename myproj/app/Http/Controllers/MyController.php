<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MyController extends Controller
{
    /**
     * git push시 실행될 함수 
     */
    public function addGitLog()
    {
        Log::info('하잉~!');
    }
}
