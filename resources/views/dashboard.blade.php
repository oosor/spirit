@extends('master')

@section('title', 'Духовное Духовным | Подстрочный перевод')

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
        <h1 class="pull-left">В начале было Слово, и Слово было у Бога, и Слово было Бог</h1>
    </div>
</div>
<div class="spacial-features">
    <section class="container">
        <div class="row">
            <div class="col-12">
                <div class="header">
                    <h2></h2>
                    <p>
                        Цель этого проекта дать русскоговорящим христианам доступ к тексту максимально приближенному к первоначальному. Поэтому, подстрочный перевод книг производится с тех языков, на которых эти книги были изначально написаны, либо с языков, на которых написаны их наиболее древние и достоверные переводы (если текст на языке оригинала утерян). Это греческий, еврейский и латинский языки.
                    </p>
                    <p>
                        В силу того, что во времена Иисуса и первых христиан перевод книг Ветхого Завета на греческий язык был распространён и цитировался при догматическом обосновании тех или иных позиций, я по возможности представлю перевод канонических книг Ветхого Завета также и с Септуагинты.
                    </p>
                    <h4 style="color:#428bca">Весь материал был взят с ресурса <a href="http://bible.in.ua" target="_blank">bible.in.ua</a></h4>
                </div>
            </div>
        </div>
    </section>
</div>

@include('blocks.footer')

@endsection