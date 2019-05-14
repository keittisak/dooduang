<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Card</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link href='https://fonts.googleapis.com/css?family=Athiti&subset=thai,latin' rel='stylesheet' type='text/css'>
</head>
<style>
    {{--  body {
        width: 100%;
        box-sizing: border-box;
        overflow: hidden;
        background: url("https://farm6.staticflickr.com/5688/21515632899_94e4ddb78a_o.jpg") no-repeat center center;
        background-size: cover;
    }  --}}
    .container .img-responsive {
        width:200px;
        max-height:200px;
    }
    .col-card {
        margin:5px;
    }
    .result {
        width:260px;
        max-height:300px;
        margin:5px;
    }
    .card-header{
        background-color:#fff;
    }
</style>
<body> 
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4>Doo Duang</h4>
                {{--  <button class="btn btn-outline-secondary" type="button" id="switchCard">สลับการ์ดทั้งหมด</button>  --}}
                <div class="input-group col-md-4" style="padding:0">
                    <div class="input-group-prepend">
                        <span class="input-group-text">อายุ</span>
                    </div>
                    <input type="text" class="form-control" name="age">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="switchCard">สลับการ์ดทั้งหมด</button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="card-deck">
                    <div class="card">
                        <h5 class="card-header">การ์ดทั้งหมด <span id="card-total">0</span>/90</h5>
                        <div class="card-body">
                            <div class="text-center">
                                <img src="{{asset('cards/card_back.jpg')}}" class="img-thumbnail result" alt="used 1" id="result-1">
                                <img src="{{asset('cards/card_back.jpg')}}" class="img-thumbnail result" alt="used 2" id="result-2">
                                <img src="{{asset('cards/card_back.jpg')}}" class="img-thumbnail result" alt="used 3" id="result-3">
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button type="button" class="btn btn-primary" id="used-card">ใช้การ์ด 10 ใบ</button>
                            {{--  <button type="button" class="btn btn-primary" id="random-card">ใช้การ์ด 10 ใบ</button>  --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <input type="hidden" value="" id="cards">
        <input type="hidden" value="" id="card-used">
        <div id="box-show-card">
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdn.rawgit.com/nnattawat/flip/master/dist/jquery.flip.min.js"></script>
<script>
        $(document).on('click', '.col-card',function(){
            var cardUsed = $("#card-used").val();
            var cardActive = $(".card-active").length;
            if(cardActive < 3)
            {
                $(this).addClass('card-active');
                $(this).flip(true);
                var cardImg = "{{asset('cards')}}/"+$(this).data('json').img;
                var i = cardActive+1;
                var resultElement = $("#result-"+i);
                resultElement.attr('alt',$(this).data('id'));
                resultElement.attr('src',cardImg);

                
            }

            if(cardActive == 2)
            {
                var setCardUsed = [];
                $(".col-card").each(function(key,element){
                    var cardData = $(element).data('json');
                    {{--  console.log(cardData);  --}}
                    if($(element).hasClass('card-active'))
                    {
                        cardData['active'] = 1;
                    }else{
                        cardData['active'] = 0;
                    }
                    setCardUsed.push(cardData);
                })
                return false;

                if(cardUsed === "")
                {
                    $("#card-used").val(JSON.stringify([setCardUsed]));
                }else{
                    cardUsed = JSON.parse(cardUsed);
                    cardUsed.push(setCardUsed);
                }
                {{--  setTimeout(function(){ alert("Hello"); }, 3000);  --}}
            }

            
        });
        $("#switchCard").on('click',function(){
            var age = $("input[name=age]").val();
            if(age == "")
            {
                alert('ใส่อายุด้วยนะจ๊ะ');
                return false;
            }

            $.ajax({
                url:`{{route('card.switch')}}`,
                method:`GET`,
                type:`JSON`,
                data:{age:age}
            }).done(function( res ) {
                $("#cards").val(JSON.stringify(res));
                $("#card-total").text(90);
            }).fail(function( jqxhr, textStatus ) {
                alert('Error');
            });

        });

        $("#used-card").on('click',function(){
            var cardTotal = $("#card-total").text();
            if(cardTotal == 0)
            {
                alert('การ์ดหมดแล้วนะจ๊ะคนสวย');
                return false;
            }
            var cards = JSON.parse($("#cards").val());
            $.ajax({
                url:`{{route('card.used')}}`,
                method:`GET`,
                type:`JSON`,
                data:{cards:cards}
            }).done(function( res ) {
                $("#cards").val(JSON.stringify(res.cards));
                cardTotal = parseInt(cardTotal)-10;
                $("#card-total").text(cardTotal);
                
                var element = "";
                $.each(res.used_cards,function(key,card){
                    var cardImg = "{{asset('cards')}}/"+card.img;
                    var cardBack = "{{asset('cards')}}/card_back.jpg";
                    var i = key+1;
                    if (i % 5 == 1)
                    {
                        element += `<div class="row">`;
                    }
                    
                    element += ` <div class="col col-card" data-id="${card.id}" data-json='${JSON.stringify(card)}'>
                            <center>${i}</center>
                            <div class="front"> 
                                <img src="${cardBack}" alt="..." class="img-thumbnail img-responsive">
                            </div> 
                            <div class="back">
                                <img src="${cardImg}" alt="..." class="img-thumbnail img-responsive">
                            </div> 
                        </div>`;
                        if (i % 5 == 0)
                        {
                            element += `</div>`;
                        }
                });
                $("#box-show-card").html(element);
                $(".col").flip({
                    trigger: 'manual'
                });

            }).fail(function( jqxhr, textStatus ) {
                alert('Error');
            });
        });

        $("#random-card").on('click',function(){
            if(cardTotal == 0)
            {
                alert('การ์ดหมดแล้วนะจ๊ะคนสวย');
                return false;
            }
            $(".result").attr('src','https://fbi.dek-d.com/27/0127/3744/121071094?v=5.9');
            $.ajax({
                url:`{{route('dooduang.random-card')}}`,
                method:`GET`,
                type:`JSON`
            }).done(function( res ) {
                var element = "";
                $.each(res,function(key,card){
                    var i = key+1;
                    if (i % 5 == 1)
                    {
                        element += `<div class="row">`;
                    }
                    
                    element += ` <div class="col col-card" data-id="${card.id}" data-json='${JSON.stringify(card)}'>
                            <center>${i}</center>
                            <div class="front"> 
                                <img src="https://img.kapook.com/image/horo%20daily/13212919211321292055l.jpg" alt="..." class="img-thumbnail img-responsive">
                            </div> 
                            <div class="back">
                                <img src="https://img.kapook.com/image/horo%20daily/13212919211321292055l.jpg" alt="..." class="img-thumbnail img-responsive">
                            </div> 
                        </div>`;
                        if (i % 5 == 0)
                        {
                            element += `</div>`;
                        }
                });
                $("#box-show-card").html(element);
                $(".col").flip({
                    trigger: 'manual'
                });

                cardTotal = parseInt(cardTotal)-10;
                $("#card-total").text(cardTotal);

            }).fail(function( jqxhr, textStatus ) {

            });
        });

</script>
</html>
