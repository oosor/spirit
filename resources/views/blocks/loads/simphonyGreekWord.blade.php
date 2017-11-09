@foreach($data as $el)
<div class="simphony-block">
    <p class="word-bold" style="font-family: GrkV">{{ $el->word }}</p>
    <small>{!! $el->detal !!}</small>
    <footer>
    <small class="text-muted">
        @foreach($el->other as $other)
        <div>
            <a class="other greek-word" data="{{ $other->code }}" style="font-family: GrkV">{{ $other->word }}</a>
            <strong>({{ $other->count }})</strong>
            @foreach($other->ruWord as $i=>$word)
            {{ $i > 0 ? ',' : '' }}
            <span> {{ $word->word . ' (' . $word->count . ')' }}</span>
            @endforeach
        </div>
        @endforeach
    </small>
    </footer>
</div>
@endforeach