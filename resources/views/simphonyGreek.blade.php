@extends('master')

@section('title', 'Духовное Духовным | Подстрочный перевод | Симфонии')

@section('styles')
    @parent

@endsection

@section('scripts')
    @parent
    <script src="{{ asset('dist/view-greek-ru.js') }}"></script>
    <script src="{{ asset('dist/simphony.js') }}"></script>
@endsection

@section('content')

    @include('blocks.header')
    <div class="breadcrumbs">
        <div class="container">
            <h1 class="pull-left">
                @switch($is)
                    @case('simphony-greek')
                    ГРЕЧЕСКО-РУССКАЯ СИМФОНИЯ
                    @break
                    @case('simphony-ru')
                    РУССКО-ГРЕЧЕСКАЯ СИМФОНИЯ
                    @break
                    @case('simphony-greek-word')
                    СИМФОНИЯ ГРЕЧЕСКИХ СЛОВАРНЫХ ФОРМ
                    @break
                @endswitch
            </h1>
        </div>
    </div>
    <div class="blog-sidebar-posts">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="post">
                        <div class="intro">
                            @if($data)
                                @switch($is)
                                    @case('simphony-greek')
                                        @include('blocks.loads.simphonyGreek')
                                        @break
                                    @case('simphony-ru')
                                        @include('blocks.loads.simphonyRu')
                                        @break
                                    @case('simphony-greek-word')
                                        @include('blocks.loads.simphonyGreekWord')
                                        @break
                                @endswitch
                            @else
                                @switch($is)
                                    @case('simphony-greek')
                                    @include('blocks.dashboards.simphonyGreek')
                                    @break
                                    @case('simphony-ru')
                                    @include('blocks.dashboards.simphonyRu')
                                    @break
                                    @case('simphony-greek-word')
                                    @include('blocks.dashboards.simphonyGreekWord')
                                    @break
                                @endswitch
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 sidebar">
                    @switch($is)
                        @case('simphony-greek')@case('simphony-ru')@case('simphony-greek-word')
                            @include('blocks.right.links3')
                            @break
                        {{--@case('simphony-ru')
                            @include('blocks.right.links3')
                            @break--}}
                    @endswitch
                </div>
            </div>
        </div>
    </div>
    @include('blocks.footer')
    @include('blocks.modals.detalWordModal')
@endsection