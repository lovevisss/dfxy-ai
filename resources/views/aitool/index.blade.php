@extends('layouts.aimaster')


@section('content')
    <div class="row">
        <div class="col-lg-2">
            <div class="btn-list mt-3" style="flex-direction: column; ">
                @foreach($categories as $category)

                    <a class="btn btn-square btn-primary" href="{{route('category.show', $category->id)}}">
                        <i class="{{$category->class}}"></i>
                        <span class="flex-1">{{$category->name}}</span>
                     </a>
                @endforeach
            </div>
        </div>
        <div class="col-lg-8">
             <div class="row ">
                    @foreach($ais as $ai)

                     <div class="col-md-6 col-lg-3 mt-3 ">
                         <a href="{{$ai->path}}">
                             <div class="card">
                                 <!-- Photo -->
                                 <div class="img-responsive img-responsive-21x9 card-img-top" style="background-image: url({{$ai->image()}})"></div>
                                 <div class="card-body">
                                     <h3 class="contents">{{$ai->name}}</h3>
                                     <p class="text-secondary" style="min-height: 140px">
                                         {{$ai->desc}}
                                     </p>
                                 </div>
                             </div>
                         </a>
                     </div>
{{--                    <div class="col-lg-4 mt-4">--}}
{{--                        <a href="{{$ai->path}}">--}}
{{--                            <div class="card">--}}
{{--                                <div class="row row-0">--}}
{{--                                    <div class="col-3">--}}
{{--                                        <!-- Photo -->--}}
{{--                                        <img src="{{$ai->image()}}" class="w-100 h-100 object-cover card-img-start" alt="Beautiful blonde woman relaxing with a can of coke on a tree stump by the beach">--}}
{{--                                    </div>--}}
{{--                                    <div class="col">--}}
{{--                                        <div class="card-body">--}}
{{--                                            <h3 class="card-title">{{$ai->name}}</h3>--}}
{{--                                            <p class="text-secondary">--}}
{{--                                                {{$ai->desc}}--}}
{{--                                            </p>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </a>--}}
{{--                    </div>--}}
                    @endforeach
             </div>
        </div>
    </div>



@endsection
