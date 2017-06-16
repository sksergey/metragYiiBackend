

$(function(){

    $.ajaxSetup({

        async: true,
        type: 'POST',
        dataType: 'json',
        timeout: 0

    });

    $("#pageSearchStart").click(searchAllPages);
    $("#request").click(serverRequest);

    function searchAllPages(){
        addMessage("Процесс поиска запущен");

        $.ajax({
            url: main_url,
            dataType: 'text',
            success: function(data){
                addMessage("Получение данных закончено");
                serverRequest();
                console.log(data);
            },
            error:function(data, txtStatus, error) {
                $(".errors").html("Работа завершена некорректно" + data);
                addMessage(txtStatus);
                addMessage(error);

                addMessage("!!!"+data.responseText+"!!!");
                console.log(main_url);
                console.log(data);
            }

        });
/*
        $.post(,function(data){

        }).fail();
        ;*/
        //addMessage("Отправлен запрос");
        //serverRequest();
    }

    function serverRequest() {
        addMessage("Запрос данных");
        $.post("/backend/web/olxparser/default/process-info",{timeout:3},function(data){
            //alert(data);
            addMessage("Ответ");
            var d = new Date;
            console.log(data);
            addMessage(data+"<br>"+d.getTime());
            //setTimeout(serverRequest,5000);

            if(data.ready < data.total){
                searchAllPages();
            }
        },"json")
        .fail(function() {
                var d = new Date;
                addMessage("Сервер не отвечает."+d.getTime());
                //setTimeout(serverRequest,5000);
        });
    }

    function addMessage($mess){
        $(".messages").html( $mess + "<br>"+ $(".messages").html());
    }
});



