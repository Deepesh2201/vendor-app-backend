<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Post</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="{{url('public/css/post.css')}}">

        <style>
            /*jssor slider loading skin double-tail-spin css*/
            .jssorl-004-double-tail-spin img {
                animation-name: jssorl-004-double-tail-spin;
                animation-duration: 1.6s;
                animation-iteration-count: infinite;
                animation-timing-function: linear;
            }

            @keyframes jssorl-004-double-tail-spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }

            /*jssor slider bullet skin 071 css*/
            .jssorb071 .i {position:absolute;color:#fff;font-family:"Helvetica neue",Helvetica,Arial,sans-serif;text-align:center;cursor:pointer;z-index:0;}
            .jssorb071 .i .b {fill:#000;opacity:.2;}
            .jssorb071 .i:hover {opacity:.7;}
            .jssorb071 .iav {color:#000;}
            .jssorb071 .iav .b {fill:#fff;opacity:1;}
            .jssorb071 .i.idn {opacity:.3;}

            /*jssor slider arrow skin 051 css*/
            .jssora051 {display:block;position:absolute;cursor:pointer;}
            .jssora051 .a {fill:none;stroke:#fff;stroke-width:360;stroke-miterlimit:10;}
            .jssora051:hover {opacity:.8;}
            .jssora051.jssora051dn {opacity:.5;}
            .jssora051.jssora051ds {opacity:.3;pointer-events:none;}
        </style>


    </head>
    <body>

        <div class="back">
        <h4 style="text-align:center; color: white;">Rent / Sale </h4>
        </div>

        <div class="container">
            <div class="heading">
                <!-- <h4>List Of Posts</h4> -->
            </div>


            @foreach($posts as $post)
                <div class="listunit">
                    <div id="jssor_{{ $loop->iteration }}" style="position:relative;margin:0 auto;top:0px;left:0px;width:960px;height:490px;overflow:hidden;visibility:hidden;">
                        <!-- Loading Screen -->

                        <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:980px;height:490px;overflow:hidden;">

                            @if($post->image1)
                                @php
                                    $filePath = public_path('images/post-images/'.$post->image1) ;
                                @endphp
                                @if(file_exists($filePath))
                                    <div data-p="735">
                                        <img data-u="image" src="{{url('public/images/post-images/'.$post->image1)}}" />
                                    </div>
                                @endif
                            @endif
                            @if($post->image2)
                                @php
                                    $filePath = public_path('images/post-images/'.$post->image2) ;
                                @endphp
                                @if(file_exists($filePath))
                                    <div data-p="735">
                                        <img data-u="image" src="{{url('public/images/post-images/'.$post->image2)}}" />
                                    </div>
                                @endif
                            @endif
                            @if($post->image3)
                                @php
                                    $filePath = public_path('images/post-images/'.$post->image3) ;
                                @endphp
                                @if(file_exists($filePath))
                                    <div data-p="735">
                                        <img data-u="image" src="{{url('public/images/post-images/'.$post->image3)}}" />
                                    </div>
                                @endif
                            @endif
                            @if($post->image4)
                                @php
                                    $filePath = public_path('images/post-images/'.$post->image4) ;
                                @endphp
                                @if(file_exists($filePath))
                                    <div data-p="735">
                                        <img data-u="image" src="{{url('public/images/post-images/'.$post->image4)}}" />
                                    </div>
                                @endif
                            @endif

                        </div>
                        <!-- <a data-scale="0" href="https://www.jssor.com" style="display:none;position:absolute;">animation</a> -->
                        <!-- Bullet Navigator -->
                        <div data-u="navigator" class="jssorb071" style="position:absolute;bottom:20px;right:20px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
                            <div data-u="prototype" class="i" style="width:24px;height:24px;font-size:12px;line-height:24px;">
                                <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;z-index:-1;">
                                    <circle class="b" cx="8000" cy="8000" r="6666.7"></circle>
                                </svg>
                                <div data-u="numbertemplate" class="n"></div>
                            </div>
                        </div>
                        <!-- Arrow Navigator -->
                        <div data-u="arrowleft" class="jssora051" style="width:55px;height:55px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
                            <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                                <polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
                            </svg>
                        </div>
                        <div data-u="arrowright" class="jssora051" style="width:55px;height:55px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
                            <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                                <polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
                            </svg>
                        </div>

                    </div>
                    <div class="descArea">
                        <a href="{{url('posts/view')}}/{{$post->id}}">
                            <div class="titleandrent">
                                <h3 style="color: #4caf4f;">{{ $post->title }}</h3>
                                <span><b>&#163;{{ $post->rent_per_month }}</b></span>
                            </div>
                            <p>Address- {{ $post->address }}</p>
                            <p>{{ $post->description }}</p>
                        </a>
                    </div>
                </div>
            @endforeach






        </div>



        <script src="{{url('public/js/jssor.slider-28.1.0.min.js')}}" type="text/javascript"></script>
        <script type="text/javascript">
        @foreach($posts as $post)
            window.jssor_{{ $loop->iteration }}_slider_init = function() {

                var jssor_{{ $loop->iteration }}_SlideoTransitions = [
                  [{b:0,d:1000,o:1}],
                  [{b:0,d:1000,y:-88,ls:0.1,e:{y:3,ls:1}}],
                  [{b:-1,d:1,da:[0,2000]},{b:600,d:1500,da:[460,2000],e:{da:1}}],
                  [{b:1600,d:500,o:0.4}],
                  [{b:1500,d:500,o:0.4}],
                  [{b:1400,d:500,o:0.7}],
                  [{b:600,d:1000,o:1}],
                  [{b:-1,d:1,tZ:-100},{b:600,d:1000,x:668,y:302,rY:12,tZ:-30,e:{x:1,y:1,rY:1,tZ:1}}],
                  [{b:-1,d:1,tZ:-20}],
                  [{b:-1,d:1,tZ:20}],
                  [{b:-1,d:1,da:[460,2000]},{b:1200,d:1500,da:[760,2000],e:{da:1}}],
                  [{b:1200,d:500,o:0.4}],
                  [{b:1100,d:500,o:0.4}],
                  [{b:1000,d:500,o:0.7}],
                  [{b:0,d:1500,y:60,o:1,e:{y:1}}],
                  [{b:-1,d:1,ls:1},{b:0,d:1500,o:1,ls:0,e:{ls:1}}],
                  [{b:-1,d:1,da:[760,2000]},{b:1600,d:1500,da:[1040,2000],e:{da:1}}],
                  [{b:1600,d:500,o:0.4}],
                  [{b:1500,d:500,o:0.4}],
                  [{b:1400,d:500,o:0.7}],
                  [{b:-1,d:1,so:1},{b:0,d:1000,so:0,e:{so:1}}],
                  [{b:-1,d:1,rY:-20}],
                  [{b:-1,d:1,so:1},{b:1000,d:1000,so:0,e:{so:1}}],
                  [{b:-1,d:1,rY:-20}],
                  [{b:-1,d:1,ls:2},{b:0,d:2000,y:68,o:0.7,ls:0.12,e:{y:7,ls:1}}],
                  [{b:-1,d:1,ls:2},{b:0,d:2000,y:68,o:0.7,ls:0.12,e:{y:7,ls:1}}],
                  [{b:1100,d:1200,y:-40,o:1},{b:2300,d:1200,y:-80,o:0}],
                  [{b:1700,d:1200,y:-40,o:1},{b:2900,d:1200,y:-80,o:0}],
                  [{b:2300,d:1200,y:-40,o:1},{b:3500,d:1200,y:-80,o:0}],
                  [{b:2900,d:1200,y:-40,o:1},{b:4100,d:1200,y:-80,o:0}],
                  [{b:3500,d:1200,y:-40,o:1},{b:4700,d:1200,y:-80,o:0}],
                  [{b:4100,d:1200,y:-40,o:1},{b:5300,d:1200,y:-80,o:0}]
                ];

                var jssor_{{ $loop->iteration }}_options = {
                  $AutoPlay: 1,
                  $CaptionSliderOptions: {
                    $Class: $JssorCaptionSlideo$,
                    $Transitions: jssor_{{ $loop->iteration }}_SlideoTransitions,
                    $Controls: [{r:1100,e:4700},{r:1700,e:5300},{r:2300,e:5900},{r:2900,e:6500},{r:3500,e:7100},{r:4100,e:7700}]
                  },
                  $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$
                  },
                  $BulletNavigatorOptions: {
                    $Class: $JssorBulletNavigator$,
                    $SpacingX: 20,
                    $SpacingY: 20
                  }
                };

                var jssor_{{ $loop->iteration }}_slider = new $JssorSlider$("jssor_{{ $loop->iteration }}", jssor_{{ $loop->iteration }}_options);

                /*#region responsive code begin*/

                var MAX_WIDTH = 980;

                function ScaleSlider() {
                    var containerElement = jssor_{{ $loop->iteration }}_slider.$Elmt.parentNode;
                    var containerWidth = containerElement.clientWidth;

                    if (containerWidth) {

                        var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                        jssor_{{ $loop->iteration }}_slider.$ScaleWidth(expectedWidth);
                    }
                    else {
                        window.setTimeout(ScaleSlider, 30);
                    }
                }

                ScaleSlider();

                $Jssor$.$AddEvent(window, "load", ScaleSlider);
                $Jssor$.$AddEvent(window, "resize", ScaleSlider);
                $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
                /*#endregion responsive code end*/
            };
        @endforeach
        </script>

<script type="text/javascript">
// jssor_1_slider_init();
 @foreach($posts as $post)
                jssor_{{ $loop->iteration }}_slider_init();
 @endforeach
</script>
    <script src="{{url('public/js/jquery.min.js')}}"></script>
    <script src="{{url('public/js/popper.js')}}"></script>
    <script src="{{url('public/js/bootstrap.min.js')}}"></script>
    <script src="{{url('public/js/main.js')}}"></script>
</body>
</html>
