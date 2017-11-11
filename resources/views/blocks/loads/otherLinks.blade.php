@foreach($data->cr as $el)
    <div class="item-other">
        <span>[{{ $el->averse }}] </span>
        @foreach($el->links as $link)
            <a href="{{ asset('view/?ot_nt=' . ($link->book > 50 && ($link->book != 78) ? 'NT' : 'OT') . '&book=' . $CONST->BOOK_LINKS_GREEK[$link->book-1] . '&chapter=' . $link->chapter . '&cn=' . $link->verse) }}">{{ $link->nameBook }} {{ $link->chapter }}:{{ $link->verse }}</a>;
        @endforeach
    </div>
@endforeach