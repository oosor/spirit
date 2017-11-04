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
                <?php
                $activeBook = strrpos($property['book'], $key) !== false;
                $activeChapter = (int)explode('_', $property['book'])[1];
                ?>
                <div id="colapse-{{ $key }}" class="collapse{{ $activeBook ? ' show' : '' }}" role="tabpanel">
                    <div class="card-body">
                        <ul class="pagination">
                            @foreach($navigation->numberLinks[$key] as $page)
                                <li class="page-item{{ $activeBook && (int)explode('_', $page->c)[1] == $activeChapter ? ' active' : '' }}">
                                    <a class="page-link ru-link" href="{{ asset('bible'.$page->href) }}">
                                        <span>{{ (int)explode('_', $page->c)[1] }}</span>
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
<div class="best-hits">
    <i class="ion-arrow-graph-up-right"></i>
    <strong>Check out our best hits</strong>
    <a href="#">How to start a business</a>
    <a href="#">How to sell online</a>
    <a href="#">Climate change when needed</a>
    <a href="#">Web development upstart</a>
    <a href="#">Learn Rails in 30 days</a>
</div>