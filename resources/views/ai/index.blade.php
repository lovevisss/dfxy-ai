<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>AI 智能体</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="{{asset('/js/jquery.min.js')}}"></script>
    <script src="{{asset('/js/tabler.min.js')}}"></script>
    <script src="{{asset('/js/select2.min.js')}}"></script>

    <link rel="stylesheet" href="{{asset('/css/tabler.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/select2.min.css')}}">

</head>
<body>
 <div class="page">
     <div class="text-center mt-3 pt-3">
         <a class="btn btn-primary " href="https://cloud.zufedfc.edu.cn/ai-knowledge/createPro">创建智能体</a>
     </div>

     <div class="flex px-2" style="flex-wrap:wrap">
{{--         <div class="card p-3">--}}
{{--             <a href="https://cloud.zufedfc.edu.cn/ai-knowledge/createPro" style="position: relative; display: inline-block;" >--}}
{{--             <img src="{{asset('images/banner.png')}}"  alt="" >--}}
{{--                 <h1 style="position: absolute; bottom: 1em; right: 1em; margin: 0;color: white; font-size: 3em;">创建AI智能体</h1>--}}
{{--             </a>--}}
{{--         </div>--}}
         <div class="badges-list px-4 py-2">
             @foreach($tags as $tag)
                 @if($tag->id != 3)
                    <a class="badge bg-yellow  rounded-full text-lg shadow-md focus:shadow-xl " href="/tag/{{$tag->id}}">{{$tag->name}}</a>
                 @endif
             @endforeach
         </div>
         <div class="row">
             @foreach($ais as $key=> $ai)
                 @if($key % $num == 0)
                     <div class="row">
                 @endif
                 <div class="flex-wrap ml-3 mt-2  flex-1" >
                     <a class="card card-link" href="{{$ai->path}}" style="height: 100%">
                         <div class="card" style="height: 100%">
                             <!-- Photo -->
                             <div class="img-responsive img-responsive-3*3 card-img-top " style="background-image: url({{$ai->image()}})"></div>
                             <div class="card-body ">
                                 @foreach($ai->tags as $t)
                                     <span class="badge {{$t->color}} text-blue-fg ">{{$t->name}} </span>
                                 @endforeach
                                 <div class="card-title mb-1 mt-2">{{$ai->name}} </div>
                                 <div class="text-secondary">{{$ai->desc}}</div>

                             </div>
                         </div>

                     </a>
                 </div>
                 @if(($key+1) % $num ==0 || $key == count($ais))

                         </div>
                 @endif
             @endforeach
         </div>
     </div>

 </div>
</body>

</html>
