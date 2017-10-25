@extends('master')

@section('title', 'Page Title')

@section('styles')
    @parent

@endsection

@section('scripts')
    @parent
    <script src="dist/view-greek-ru.js"></script>
@endsection

@section('content')

@include('blocks.header')


<div class="blog-sidebar-posts">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="post">
                    <div class="title">
                        <a href="blog-post.html">A brief history of climate science</a>
                    </div>
                    <div class="author">
                        <img src="images/uifaces/11.jpg" class="avatar" alt="author" />
                        Jessica Smith, October 03, 2015
                    </div>
                    <div class="intro" data="{{ $data[0]->ot_nt . '.' . $data[0]->book }}">
                        <div class="title">
                        @foreach($data as $el)
                            @for($i=0;$i<count($el->a_1->data);$i++)
                                    {!! $i == 8 ? '</div>' : '' !!}
                                @if(empty($el->a_1->data[$i]))
                                    {!! $i < 9 ? '' : '<br>' !!}
                                    @continue
                                @endif
                        <div class="word-block">
                            <span class="word greek-word{{ (ctype_digit($el->a_1->data[$i])) ? (' digit' . ($i < 8 ? ' chapter' : '')) : '' }}" data="{{ $el->a_3->data[$i] }}">{!! $el->a_1->data[$i] !!}</span>
                            <span class="word ru-word" data="{{ $el->a_4->data[$i] }}">{!! $el->a_4->data[$i] !!}</span>
                        </div>
                            @endfor
                        @endforeach
                    </div>
                    <a href="blog-post.html" class="continue-reading">Continue reading this post</a>
                </div>
            </div>
            <div class="col-lg-3 sidebar">
                <div class="updates">
                    <i class="fa fa-rss"></i>
                    <strong>
                        Free blog updates
                    </strong>
                    <p>
                        Never miss an update.
                        Sign up  to receieve an email whenever we post something in the blog.
                    </p>
                    <a href="#" class="btn-shadow btn-shadow-primary">Subscribe now</a>
                </div>
                <div class="best-hits">
                    <i class="ion-arrow-graph-up-right"></i>
                    <strong>Check out our best hits</strong>
                    <a href="#">How to start a business</a>
                    <a href="#">How to sell online</a>
                    <a href="#">Climate change when needed</a>
                    <a href="#">Web development upstart</a>
                    <a href="#">Learn Rails in 30 days</a>
                </div>
            </div>
        </div>
    </div>
</div>
@include('blocks.footer')
@include('blocks.modals.detalWordModal')
@endsection