$(function(){
    $.ajaxSetup({
        async: true,
        type: 'POST',
        dataType: 'json',
        timeout: 0
    });

    $("#pageSearchStart").click(searchAllPages);
    $("#linksParseStart").click(linksParse);

    //======================== парсинг страниц
    function searchAllPages(){
        addMessage("Поиск...");
        $.ajax({
            url: main_url,
            dataType: 'text',
            success: function(data){
                serverPagesRequest();
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
    }

    //=====================парсинг уникальных ссылок
    function linksParse() {
        addMessage("link parse...");
        $.ajax({
            url: "/admin/olxparser/default/handle-apartments-links",
            success: function (data) {
                console.log(data);
                serverLinksRequest();
            },
            error: function (data, txtStatus, error) {
                $(".errors").html("Работа завершена некорректно" + data);
                addMessage(txtStatus);
                addMessage(error);
                console.log(main_url);
                console.log(data);
            }
        });
    }

    function serverPagesRequest() {
        $.post("/admin/olxparser/default/process-pages-info",{timeout:5},function(data){
            console.log(data);
            addMessage("total:"+data.total+" :: ready:"+data.ready);
            if(parseInt(data.ready) < parseInt(data.total)){
                searchAllPages();
            }
        },"json")
            .fail(function() {
                var d = new Date;
                addMessage("WTF?Сервер не отвечает."+d.getHours() + ":"
                    + d.getMinutes() + ":" + d.getSeconds());
            });
    }

    function serverLinksRequest() {
            $.post("/admin/olxparser/default/process-links-info",{timeout:5},function(data){
                console.log(data);
                addMessage("total:"+data.total+" :: ready:"+data.ready);
                if(parseInt(data.ready) < parseInt(data.total) ){
                    linksParse();
                }
            },"json")
                .fail(function() {
                    var d = new Date;
                    addMessage("WTF?Сервер не отвечает."+d.getHours() + ":"
                        + d.getMinutes() + ":" + d.getSeconds());
                });
        }

   function addMessage($mess){
        $(".messages").html( $mess + "<br>"+ $(".messages").html());
    }
});



