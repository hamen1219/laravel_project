<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>업비트 소켓 테스트</title>
</head>

<body>

    <h3>업비트 소켓 테스트 </h3><hr>
    
    <h5>종목별 실시간 정보 보기</h5>

    <select name="code" id="code" class="code" onchange="javascript:selectedCode();">
        @foreach ($type as $name => $code)
            <option value="{{$code}}">{{$name}}</option>
        @endforeach
    </select>
    
    <div>
        <p>종목코드 : <span id='stock_code'></span></p> 
        <p>시가 : <span class='prc common'></span></p> 
        <p>체결 : <span class='prc high'></span></p> 
        <p>호가 : <span class='prc low'></span></p>    
    </div>
    
</body>

<script>
    // ws : 웹 소켓 프로토콜 
    
    // 소켓 생성시 사용 가능한 메서드 
    /*
        open : 커넥션이 제대로 만들어졌을때 발생
        message : 데이터를 수신하였을 때 발생함
        error : 에러가 생겼을 때 발생함
        close : 커넥션이 종료되었을 때 발생함
    */
    var code = '';

    function selectedCode() {

        let new_code = document.getElementsByName('code')[0].value;

        if(new_code===undefined) {
            alert('올바르지 않은 코인 코드');
            return false ;
        }
        code = new_code;

        console.log(code);

        
        // 소켓 생성
        var socket = new WebSocket("wss://api.upbit.com/websocket/v1");    

        // 소켓 연결 성공시
        socket.onopen = function(e){
            console.log('소켓 연결에 성공하였습니다.' + code);

            var options = [
                {
                    ticket : 1219,
                } ,
                {
                    type : 'ticker',
                    codes : [code]
                }
            ];

            var data = JSON.stringify(options) ;

            // 요청하기
            socket.send(data);         

        };

        // 메세지 수신시
        socket.onmessage = function(e){                    

            // 바이너리 데이터인 경우 
            if (e.data instanceof Blob) {                

                reader = new FileReader();

                reader.onload = () => {
                    data = JSON.parse(reader.result);

                    if(data!==null) {
                        document.getElementById('stock_code').innerHTML = data.code;
                        document.getElementsByClassName('low')[0].innerHTML = data.row_price == null ? '':  data.row_price;
                        document.getElementsByClassName('high')[0].innerHTML = data.high_price == null ? '' : data.high_price;
                        document.getElementsByClassName('comm')[0].innerHTML = data.opening_price == null ? '' : data.opening_price;
                    }                   
                };
;
                reader.readAsText(e.data)
            
            } else {

                console.log("Result: " + e.data);
            }
        };

        // 연결 오류시 
        socket.onerror = function(e) {
            console.log('소켓 오류.');
        }
    }



 
    









</script>


</html>