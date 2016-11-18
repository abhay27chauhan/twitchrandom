@extends('layouts.wrapper')

@section('title')
<title>{{ $name }} Stream | TwitchRandom</title>
@stop

@section('meta')
<meta name="description" content="TwitchRandom.com - {{ $name }} Stream. Find something unexpected at https://twitchrandom.com!">
@stop

@section('css')
@stop

@section('js')
<script>
    @include("layouts.js.loading")

    function loadGallery(galleryURL, galleryID){
        $.ajax({
            url: galleryURL
        }).done(function(data){
            $(galleryID+" .loading").hide();
            $(galleryID).append(data).show();
            $(galleryID+" .gallery-cont").niceScroll({cursorcolor:"#6441A5",cursoropacitymin:1,cursorwidth: "10px"})
            $(galleryID+" .gallery-reload").click(function(){
                $(galleryID+" .loading").show();
                $(galleryID+" .gallery-holder").remove();
                loadGallery(galleryURL, galleryID);
            });
        }).fail(function(data){
            console.log(data);
        });
    }

    $(document).ready(function(){
        //$("html").niceScroll({cursorcolor:"#6441A5"});
        var manStateChange = true;
        var firstStream = "";
        var mainGame = "";
        History.Adapter.bind(window,'statechange',function(){ // Note: We are using statechange instead of popstate
            var State = History.getState(); // Note: We are using History.getState() instead of event.state
            if(manStateChange == true){
                //loadStream(State.title);
                if(State.data.stream){
                    var ajaxurl = "/ajax/stream/"+State.data.stream;
                }else{
                    var ajaxurl = "/ajax/stream/"+firstStream;
                }
                $("#main-stream-container").remove();
                $("#stream-loading").show();
                $.ajax({
                    url: ajaxurl
                }).done(function(data){
                    $(".jumbotron").append(data);
                    var mainGame = $(".display-playing a").text();
                    if(mainGame){
                        $("#random-game-gallery .title").text(mainGame+" | Random Streams");
                        $("#random-game-gallery .gallery-holder").remove();
                        loadGallery("/ajax/game/"+rawurlencode(mainGame)+"/9", "#random-game-gallery");
                    }else{
                        $("#random-game-gallery").hide();
                    }
                    //var historyurl = $("#main-stream-container .display-name").attr("href");
                }).fail(function(data){
                    console.log(data);
                });
            }
            manStateChange = true;
        });

        $.ajax({
            url: "/ajax/stream/{{ rawurlencode($name) }}"
        }).done(function(data){
            $(".jumbotron").append(data);
            var mainGame = $(".display-playing a").text();
            if(mainGame){
                $("#random-game-gallery .title").text(mainGame+" | Random Streams");
                $("#random-game-gallery .gallery-holder").remove();
                loadGallery("/ajax/game/"+rawurlencode(mainGame)+"/9", "#random-game-gallery");
            }else{
                $("#random-game-gallery").hide();
            }
            firstStream = $("#main-stream-container .display-name").data("streamlink");
        }).fail(function(data){
            console.log(data);
            $(".jumbotron>.loading>.text").addClass("error").text("Error: "+data.responseJSON.error.message);
        });
        loadGallery("/ajax/gallery", "#gallery-all");
        loadGallery("/ajax/featured/3", "#gallery-featured");

        $(".gallery-control-left").click(function(){
            if(!$(this).hasClass("disabled")){
                var gallery = $(this).siblings(".gallery-holder").find(".gallery-cont");
                var left = gallery.scrollLeft();
                var width = gallery.width() + 15;
                gallery.getNiceScroll(0).doScrollLeft(left - width,400);
            }
        });
        $(".gallery-control-right").click(function(){
            if(!$(this).hasClass("disabled")){
                var gallery = $(this).siblings(".gallery-holder").find(".gallery-cont");
                var left = gallery.scrollLeft();
                var width = gallery.width() + 15;
                gallery.getNiceScroll(0).doScrollLeft(left + width,400);
            }
        });

        $(".jumbocontainer").on("click", "#randomize-stream", function(e){
            e.preventDefault();
            $("#main-stream-container").remove();
            $("#stream-loading").show();
            $.ajax({
                url: "/ajax/randomStream/true"
            }).done(function(data){
                $(".jumbotron").append(data);
                var historyurl = $("#main-stream-container .display-name").data("streamlink");
                var mainGame = $(".display-playing a").text();
                if(mainGame){
                    $("#random-game-gallery .title").text(mainGame+" | Random Streams");
                    $("#random-game-gallery .gallery-holder").remove();
                    loadGallery("/ajax/game/"+rawurlencode(mainGame)+"/9", "#random-game-gallery");
                }else{
                    $("#random-game-gallery").hide();
                }
                manStateChange = false;
                History.pushState({state:"/stream/"+historyurl,stream:historyurl},"TwitchRandom | "+historyurl,"/stream/"+historyurl);
            }).fail(function(data){
                console.log(data);
            });
        });

        //setInterval(function(){ $(".loading:visible>.text").setRandomText(); }, 1600);
    });
</script>
@stop

@section('content')
@include("layouts.header")
<div class="jumbocontainer">
    @include("layouts.ads.horizontal")
    <div class="container med-container stream-container">
        <div class="jumbotron">

        </div>
    </div>
</div>
<div class="gallery-container lg-container">
    {{--<div class="alert alert-info slogan-highlight"><span class="glyphicon glyphicon-certificate"></span> Got a good idea for a slogan? <a href="/slogans">Submit a new slogan for TwitchRandom!</a></div>--}}
    <div class="row">
        <div class="gallery featured col-lg-9 col-md-12" id="gallery-featured">
            <div class="gallery-title">
                <span class="title">Featured Streams</span>
            </div>
            <div class="loading" id="featured-gallery-loading">
                <img src="/img/loading.gif" alt="loading">
                <span class="text">Loading Gallery...</span>
            </div>
        </div>
        <div class="col-lg-3 col-md-12 ad block">
            @include("layouts.ads.block")
        </div>
    </div>
    <div class="row">
        <div class="gallery col-sm-12" id="gallery-all">
            <div class="gallery-title">
                <span class="title">Random Streams</span>
            </div>
            <div class="gallery-control gallery-control-left"><span class="glyphicon glyphicon-chevron-left"></span></div>
            <div class="gallery-control gallery-control-right"><span class="glyphicon glyphicon-chevron-right"></span></div>
            <div class="loading" id="gallery-loading">
                <img src="/img/loading.gif" alt="loading">
                <span class="text">Loading Gallery...</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="gallery col-sm-12" id="random-game-gallery">
            <div class="gallery-title">
                <span class="title">Game Streams</span>
            </div>
            <div class="gallery-control gallery-control-left"><span class="glyphicon glyphicon-chevron-left"></span></div>
            <div class="gallery-control gallery-control-right"><span class="glyphicon glyphicon-chevron-right"></span></div>
            <div class="loading" id="game-gallery-loading">
                <img src="/img/loading.gif" alt="loading">
                <span class="text">Loading Gallery...</span>
            </div>
        </div>
    </div>
</div>
@include("layouts.ads.horizontal2")
@include("layouts.footer")
@stop