<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dooduang</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{--  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">  --}}
  <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
  <link href="https://fonts.googleapis.com/css?family=Athiti&subset=thai,latin" rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">  
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
</style>
<body> 
    <div class="container mt-3">
        <h2>Doo Duang</h2>
        <br>
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="col-form-label">Name</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="col-form-label" >Age</label>
                            <input type="number" class="form-control" name="age">
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary" type="button" id="switchCard">Switch Card</button>
            </div>
            <div class="col-6">
                    <label class="col-form-label" >&nbsp;</label>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>Card Total <span id="card-total" class="ml-3">0</span>/90</div>
                        <button type="button" class="btn btn-warning d-none" id="used-card">Use Card</button>
                    </li>
                </ul>
            </div>
        </div>
        <br>
        <hr style="border-color:#fff">
        <div class="row">
            <div class="col-12">
                <h2>Cards</h2>
            </div>
        </div>
        <br>
        {{--  <div class="row d-none">
            <div class="col-md-12">
                <div class="card-deck">
                    <div class="card bg-light">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>  --}}
        <input type="hidden" value="" id="cards">
        <input type="hidden" value="" id="card-used">
        <div id="box-show-card">
        </div>
    </div>

    <div class="modal fade" id="result-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Answer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img src="{{asset('cards/card_back.jpg')}}" class="img-thumbnail result" alt="used 1" id="result-1">
                    <img src="{{asset('cards/card_back.jpg')}}" class="img-thumbnail result" alt="used 2" id="result-2">
                    <img src="{{asset('cards/card_back.jpg')}}" class="img-thumbnail result" alt="used 3" id="result-3">
                </div>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="loading-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
            <div class="modal-body">
                <center>
                    <h2><i class="fas fa-circle-notch fa-spin"></i></h2>
                    <h4>Switch Card </h4>
                </center>
            </div>
            </div>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdn.rawgit.com/nnattawat/flip/master/dist/jquery.flip.min.js"></script>
<script>
        
        $(document).on('click', '.show-answer',function(){
            var cardImg = $(this).data('imgs');
            $.each(cardImg,function(key,img){
                key += 1;
                $("#result-"+key).attr('src',img);
            });
            $("#result-modal").modal("show");
        });
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
                    if($(element).hasClass('card-active'))
                    {
                        cardData['active'] = 1;
                    }else{
                        cardData['active'] = 0;
                    }
                    setCardUsed.push(cardData);
                })

                if(cardUsed === "")
                {
                    $("#card-used").val(JSON.stringify([setCardUsed]));
                }else{
                    cardUsed = JSON.parse(cardUsed);
                    cardUsed.push(setCardUsed);
                    $("#card-used").val(JSON.stringify(cardUsed));
                }

                var answerCardImg = [];
                $(".result").each(function(key,element){
                    answerCardImg.push($(element).attr('src'));
                });

                var answer = `<li class="list-group-item d-flex justify-content-between align-items-center answer-li">
                        Answer ${JSON.parse($("#card-used").val()).length}
                        <button type="button" class="btn btn-info btn-sm show-answer" data-imgs='${JSON.stringify(answerCardImg)}'><i class="fas fa-search"></i></button>
                        </li>`;
                
                setTimeout(function(){
                    $("#result-modal").modal("show");
                    $('.list-group').append(answer);
                }, 500);
            }

            
        });
        $("#switchCard").on('click',function(){
            var age = $("input[name=age]").val();
            if(age == "")
            {
                alert('ใส่อายุด้วยนะจ๊ะ');
                return false;
            }
            $("#loading-modal").modal('show');
            $.ajax({
                url:`{{route('card.switch')}}`,
                method:`GET`,
                type:`JSON`,
                data:{age:age}
            }).done(function( res ) {
                $("#cards").val(JSON.stringify(res));
                $("#card-total").text(90);
                $("#used-card").removeClass('d-none');
                $(".answer-li").remove();
                $("#box-show-card").html("");
                setTimeout(function(){
                    $("#loading-modal").modal('hide');
                },1000);
            }).fail(function( jqxhr, textStatus ) {
                alert('Error');
            });

        });

        $("#used-card").on('click',function(){
            var cardTotal = $("#card-total").text();
            if(cardTotal == 10)
            {
                $("#used-card").addClass('d-none');
                {{--  alert('การ์ดหมดแล้วนะจ๊ะคนสวย');
                return false;  --}}
            }
            var cards = JSON.parse($("#cards").val());
            $.ajax({
                url:`{{route('card.used')}}`,
                method:`POST`,
                type:`JSON`,
                data:{cards:cards,_token: "{{ csrf_token() }}"}
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
                $(".result").attr('src',"{{asset('cards')}}/card_back.jpg");

            }).fail(function( jqxhr, textStatus ) {
                alert('Error');
            });
        });

</script>
</html>
