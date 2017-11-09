@foreach($data as $el)
    <div class="simphony-block">
        <p class="word-bold" style="font-family: GrkV">{{ $el->header->greek }}</p>
        <small>
            @foreach($el->links as $link)
            <div>- <a class="ru-word" data="{{ $link[0] }}">{!! $link[0] !!}</a>
                <span>{{ $link[1] }}</span>
                @foreach($link[2] as $_link)
                    {!! strrpos($_link->nameBook, '..') === false ? ('<a class="greek-chapter" data="' . $_link->ot_nt_gl . '/' . $_link->numberBook . '">' . $_link->nameBook . ' ' . $_link->numberBook . '</a>; ') : ('<span>' . $_link->nameBook . '</span>') !!}
                @endforeach
            </div>
            @endforeach
        </small>
        <footer>
            <small class="text-muted">
                <div>
                    <span>сл.ф.:</span> <a class="symphony" data="{{ $el->header->otherGreek->code }}" style="font-family: GrkV">{{ $el->header->otherGreek->greek }}</a>
                </div>
                @if(count($el->emptys) > 0)
                <div><span>см.т.:</span>
                @foreach($el->emptys as $empty)
                    <a class="other greek-word" data="{{ $empty->code }}" style="font-family: GrkV">{{ $empty->word }}</a>
                @endforeach
                <div>
                @endif
            </small>
        </footer>
    </div>
@endforeach