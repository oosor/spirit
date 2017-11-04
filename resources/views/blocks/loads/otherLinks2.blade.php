@foreach($data->f as $el)
    <div class="item-other">
        <span>[{{ $el->verse }}] </span>
        @foreach($el->links as $link)
            <a href="{{ asset('bible/?book=' . ((iconv_strlen($link->digit1) == 2 ? $link->digit1 : '0' . $link->digit1) . '_' . (iconv_strlen($link->digit2) == 3 ? $link->digit2 : (iconv_strlen($link->digit2) == 2 ? ('0' . $link->digit2) : ('00' . $link->digit2)) ))) }}">{{ $link->book }} {{ $link->digit2 }}:{{ $link->digit3 }}</a>;
        @endforeach
    </div>
@endforeach
<div class="other-2-links">
@foreach($data->cr as $el)
    <div class="item-other">
        <span>[{{ $el->averse }}] </span>
        @foreach($el->links as $link)
            <a href="{{ asset('bible/?book=' . ((iconv_strlen($link->book) == 2 ? $link->book : '0' . $link->book) . '_' . (iconv_strlen($link->chapter) == 3 ? $link->chapter : (iconv_strlen($link->chapter) == 2 ? ('0' . $link->chapter) : ('00' . $link->chapter)) ))) }}">{{ $link->nameBook }} {{ $link->chapter }}:{{ $link->verse }}</a>;
        @endforeach
    </div>
@endforeach
</div>