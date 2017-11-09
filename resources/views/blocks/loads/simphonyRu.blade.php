@foreach($data as $el)
<div class="simphony-block">
    <p class="word-bold">{{ $el->header }}</p>
    <small class="text-muted">
        @foreach($el->links as $link)
        <div>
            <a class="other greek-word" data="{{ $link->code }}" style="font-family: GrkV">{{ $link->word }}</a>
        </div>
        @endforeach
    </small>
    <footer>
        <small class="text-muted">
        @if(count($el->emptys) > 0)
        <div><span>см.т.:</span>
            @foreach($el->emptys as $empty)
            <a class="other ru-word" data="{{ $empty }}">{{ $empty }}</a>;
            @endforeach
        </div>
        @endif
    </small>
    </footer>
</div>
@endforeach