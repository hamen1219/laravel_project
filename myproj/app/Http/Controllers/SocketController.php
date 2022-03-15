<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * PHP Socket Controller
 */
class SocketController extends Controller
{

    /**
     * 소켓 페이지 
     */
    public function socketPage()
    {

    }

    /**
     * 소켓 클라이언트
     */
    public function socketClient()
    {
        // php.ini 의 socket 활성화

        define("_IP", "123.123.123.12"); 
        define("_PORT", "65000"); $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); 
        
        socket_connect($sock, _IP, _PORT); 
        echo "CLIENT >> socket connect to "._IP.":"._PORT."\n"; 
        $date = socket_read($sock, 4096); 
        echo "CLIENT >> this time is $date \n"; 
        socket_close($sock); 
        echo "CLIENT >> socket closed.\n";

    }

    /**
     * 소켓 서버
     */
    public function socketServer()
    {

    }
}
