<ul class="pagination">
    @foreach($pagination as $page)
        <li class="page-item{{ $page->active ? ' active' : '' }}">
            <a class="page-link" href="{{ asset('bible'.$page->href) }}">
                <span>{{ $page->chapter }}</span></a>
        </li>
    @endforeach
</ul>