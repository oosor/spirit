@extends('master')

@section('title', 'Page Title')

@section('styles')
    @parent

@endsection

@section('scripts')
    @parent
    <script src="{{ asset('dist/comment.js') }}"></script>
@endsection

@section('content')

    @include('blocks.header')
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