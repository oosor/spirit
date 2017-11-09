@extends('master')

@section('title', 'Page Title')

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
    <div class="blog-sidebar-posts">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="post">
                        <div class="intro" data="">
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