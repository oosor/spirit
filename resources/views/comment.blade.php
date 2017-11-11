@extends('master')

<<<<<<< HEAD
@section('title', 'Page Title')
=======
@section('title', 'Духовное Духовным | Подстрочный перевод | Толковая Библия ')
>>>>>>> a6058888dbd006a7cac15c73ed6194afed79a5d3

@section('styles')
    @parent
@endsection

@section('scripts')
    @parent
    <script src="{{ asset('dist/comment.js') }}"></script>
@endsection

@section('content')

    @include('blocks.header')
    <div class="breadcrumbs">
        <div class="container">
            <h1 class="pull-left">ТОЛКОВАЯ БИБЛИЯ</h1>
        </div>
    </div>
    <div class="blog-sidebar-posts">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="post">
                        <div class="intro">
                            @include('blocks.loads.comment')
                        </div>
                        <div class="pages">
                            @include('blocks.paginator.paginator3')
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 sidebar">
                    @include('blocks.right.links4')
                </div>
            </div>
        </div>
    </div>
    @include('blocks.footer')
    @include('blocks.modals.detalWordModal')
@endsection