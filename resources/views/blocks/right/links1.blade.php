<div class="updates">
    <strong>
        Содержание
    </strong>

    <div id="accordion">
        @foreach($navigation->bookLinks as $key=>$link)
        <div class="card">
            <div class="card-header" id="heading-{{ $key }}">
                <a data-toggle="collapse" data-parent="#accordion" href="#colapse-{{ $key }}">
                    <h5 class="mb-0">{{ $link->name }}</h5>
                </a>
            </div>
            <?php $activeBook = $property['book'] == $key;?>
            <div id="colapse-{{ $key }}" class="collapse{{ $activeBook ? ' show' : '' }}" role="tabpanel">
                <div class="card-body">
                    <ul class="pagination">
                        @foreach($navigation->numberLinks[$key] as $page)
                            <li class="page-item{{ $activeBook && $page->chapter == $property['chapter'] ? ' active' : '' }}">
                                <a class="page-link" href="{{ asset('view'.$page->href) }}">
                                    <span>{{ $page->chapter }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@include('blocks.right.two')