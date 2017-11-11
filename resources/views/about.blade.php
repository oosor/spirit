@extends('master')

<<<<<<< HEAD
@section('title', 'Page Title')
=======
@section('title', 'Духовное Духовным | Подстрочный перевод | О программе ')
>>>>>>> a6058888dbd006a7cac15c73ed6194afed79a5d3

@section('styles')
    @parent
@endsection

@section('scripts')
    @parent
@endsection

@section('content')

    @include('blocks.header')
    <div class="breadcrumbs">
        <div class="container">
            <h1 class="pull-left">О программе</h1>
        </div>
    </div>
    <div class="spacial-features">
        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header">
                        <h2></h2>
                        <p>
                        </p>
                        <p>
                        </p>
                        <h4 style="color:#428bca">Весь материал был взят с ресурса <a href="http://bible.in.ua" target="_blank">bible.in.ua</a></h4>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('blocks.footer')

@endsection