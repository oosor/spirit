<ul class="pagination">
    @foreach($pagination as $page)
        <li class="page-item{{ $page->active ? ' active' : '' }}">
            <a class="page-link ru-link" href="{{ asset('bible'.$page->href) }}">
                <span>{{ (int)explode('_', $page->c)[1] }}</span></a>
        </li>
    @endforeach
</ul>