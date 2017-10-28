@extends('master')

@section('title', 'Page Title')

@section('styles')
    @parent

@endsection

@section('scripts')
    @parent
    <script src="{{ asset('dist/view-greek-ru.js') }}"></script>
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
                    <div class="intro" data="{{ $data->ot_nt . '.' . $data->book }}">
                        <div class="title">
                            @for($i=0;$i<count($data->a_1->data);$i++)
                                    {!! $i == 8 ? '</div>' : '' !!}
                                @if(empty($data->a_1->data[$i]))
                                    {!! $i < 9 ? '' : '<br>' !!}
                                    @continue
                                @endif
                            <div class="word-block">
                                <span class="word greek-word{{ (ctype_digit($data->a_1->data[$i])) ? (' digit' . ($i < 8 ? ' chapter' : '')) : '' }}" data="{{ $data->a_3->data[$i] }}">{!! $data->a_1->data[$i] !!}</span>
                                <span class="word ru-word" data="{{ $data->a_4->data[$i] }}">{!! $data->a_4->data[$i] !!}</span>
                            </div>
                            @endfor
                        </div>
                        <div class="box-other">
                            @foreach($data->cr as $el)
                            <div class="item-other">
                                <span>[{{ $el->averse }}] </span>
                                @foreach($el->links as $link)
                                <a href="{{ asset('view/?ot_nt=' . ($link->book > 50 && ($link->book != 78) ? 'NT' : 'OT') . '&book=' . $CONST->BOOK_LINKS_GREEK[$link->book-1] . '&chapter=' . $link->chapter . '&cn=' . $link->verse) }}">{{ $link->nameBook }} {{ $link->chapter }}:{{ $link->verse }}</a>;
                                @endforeach
                            </div>
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