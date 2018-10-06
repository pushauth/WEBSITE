<html>
<head></head>
<body>
{{$user->name or 'null'}}
<br>
{{ Request::cookie('name')  }}
<button id="btn">Check</button>
</body>

<footer>

</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
{!! Html::script('http://127.0.0.1:3001/socket.io/socket.io.js')!!}

<script>
    $(document).ready(function() {



        $('body').on('click', '#btn', function(event) {
            event.preventDefault();
            //$('#myModal').modal('hide');
            // var hash= $(this).attr('data-app-hash');

            $.ajax({
                type: "POST",
                url: "{{route('c') }}",
                data: {
                   v:'vv'
                },
                success: function(data) {


                    console.log(data);
                }
            });



            //


        });


        var dataArr = {
                name:'a',
                second:'b'
            };



        var socket = io.connect( 'http://127.0.0.1:3001/', {
            "secure": false,
            // "reconnection": false,
            "reconnectionDelay": 1000,
            "reconnectionDelayMax": 1000,
            "reconnectionAttempts": 4
        });



        socket.on("connect", function(){

            socket.emit('join', {
                public_key: '12345678901234567890123456789012'
            });

            console.log('Connected: '+ socket.id);

            socket.emit('msg', dataArr);

        });


        socket.on('disconnect', function() {
            console.log('Server disconnect!');
        });

        socket.on("webPush", function(data) {
            console.log(data);
        });


    });
</script>

</html>

