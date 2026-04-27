@extends('layouts.master')


@section('content')

    <div class="page-body">

        @include('components.sidebar')
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="row row-cards">

                        @foreach($categories as $category)
                            <h1 id="{{$category->id}}">{{$category->name}}</h1>

                            @foreach($category->links as $link)

                                <div class="col-sm-6 col-lg-3">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                    <span class="bg-primary text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                                        @if($link->image())
                                                            <img src="{{$link->image()}}" >
                                                        @else
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2"></path><path d="M12 3v3m0 12v3"></path></svg>

                                                        @endif

                                                        </span>
                                                    </div>
                                                    <div class="col">
                                                        <a href="{{$link->url}}">
                                                        <div class="font-weight-medium">
                                                            {{$link->title}}
                                                        </div>
                                                        <div class="text-secondary">
                                                            {{$link->desc}}
                                                        </div>
                                                        </a>
                                                    </div>
                                                    <div class="col-3">
                                                        <a href="{{route('link.edit', $link)}}">修改</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>

                            @endforeach
                        @endforeach

                    </div>

                </div>




            </div>


        </div>
    </div>

@endsection
