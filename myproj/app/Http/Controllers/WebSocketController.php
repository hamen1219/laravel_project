<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebSocketController extends Controller
{
    /**
     * API KEY 
     */
    const ACC_KEY = "kuO3JQItdx8E7UmLfoOBIizvidPfXdFULcN9bTqx";

    /**
     * SECRET KEY
     */
    const SEC_KEY = "WZA9IjpsplYqGCVpZvIO70EFiemFdEvete98wR14";

    static function dump($data, $title = "")
    {
        if($title != "") {
            print "<h3>{$title}</h3>";
        }

        print "<pre>";
        var_dump($data);
        print "</pre>";

        return ;
    }

    /**
     * 문자열 자르기 및 배열화
     */
    static function getDataArr($res_str) 
    {
        if(empty($res_str)) {
            return [];
        }

        // 필요 없는 문자열 빼기
        $data_str = substr($res_str, strpos($res_str, "[{"));
        
        return json_decode($data_str) ?? [];
    }


    //
    public function index() 
    {
        return view('test.index');
    }

    /**
     * 마켓 코드 조회 
     */
    public function marketCodeList()
    {
               
        $params = http_build_query(['isDetails'=>false]);
        $url = "https://api.upbit.com/v1/market/all?{$params}";

        $headers = [
            'Accept' => 'application/json',
        ];  
        
        $options = [];

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_HEADER => 1, 
            CURLOPT_HTTPHEADER => $headers,   
            CURLOPT_RETURNTRANSFER=> 1,
        ]);
  
        $res = curl_exec($ch);

        // close 
        curl_close($ch);

        $rs = self::getDataArr($res);

        self::dump($rs);
        
        // 반환 데이터 정보 
        return ;

    }

    public function getCandle($mode) 
    {
        $headers = [
            'Accept'=>'application/json'
        ];

        switch($mode)
        {
            case "minute" :
                $title = "분(Minute) 캔들" ;
                $url  = 'https://api.upbit.com/v1/candles/minutes/1?market=KRW-BTC&count=1';
                break ;

            case "day" : 
                $title = "일(Day) 캔들" ;
                $url = 'https://api.upbit.com/v1/candles/days?count=1';
                break ; 

            case "week" : 
                $title = "주(Day) 캔들" ;
                $url = 'https://api.upbit.com/v1/candles/weeks?count=1';
                break ;

            case "month" : 
                $title = "월(Month) 캔들" ;
                $url = 'https://api.upbit.com/v1/candles/months?count=1';
                break ;

            default : 
                return "잘못된 캔들 타입" ;
        }

        $ch = curl_init(); 
        
        curl_setopt_array($ch, [
            CURLOPT_URL => $url ,
            CURLOPT_HEADER => 1, 
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => 1
        ]);

        $res = curl_exec($ch); 
        curl_close($ch);

        return $res;

        $rs = self::getDataArr($res);

        self::dump($rs, $title);

        return ;
    }

    /**
     * 소켓 테스트하기
     */
    public function socketPage(Request $request)
    {

        $data['type'] = [
            '리플' => 'KRW-XRP',
            '비트코인' => 'KRW-BTC',
            '이더리움' => 'KRW-ETH',            
        ];

        return view('test.socket', $data);

    }

}
