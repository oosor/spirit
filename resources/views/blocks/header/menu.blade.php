<nav class="navbar navbar-expand-lg navbar-dark bg-transparent {{--fixed-top--}}" role="navigation">
    <div class="container no-override">
        <a class="navbar-brand" href="https://spiritfount.com">
            <img src="images/logo-alt-w.png" class="d-none d-lg-inline mr-2 w-25" />
            spiritfount.com
        </a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbar-collapse">
            <ul class="navbar-nav">
                <li class="nav-item{{ $is == 'home' ? ' active' : '' }}">
                    <a href="{{ asset('') }}" class="nav-link">
                        Главная
                    </a>
                </li>
                <li class="nav-item dropdown dropdown-extend{{ $is == 'greek' ? ' active' : '' }}">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        Подстрочный перевод
                        <i class="fa fa-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-extend-menu dropdown-menu-dark" role="menu">
                        <div class="d-none d-lg-block">
                            <div class="row">
                                <?php
                                $i = 0;
                                $array1 = $is == 'greek' ? $navigation->bookLinks : $navigation->otherBookLinks->bookLinks;
                                ?>
                                @foreach($array1 as $link)
                                    @if($i % 10 == 0)
                                <div class="col-md-2"{!! $i == 20 ? ' style="border-right: 1px solid #d9d9d9"' : '' !!}>
                                    @endif
                                    <a class="dropdown-item" href="{{ asset('view' . $link->href) }}">{{ $link->name }}</a>
                                    @if(($i + 1) % 10 == 0 || $i + 1 == count($array1))
                                </div>
                                    @endif
                                    <?php $i++; ?>
                                @endforeach
                            </div>
                        </div>
                        <div class="d-md-block d-lg-none">
                            <div class="row">
                                <?php
                                $i = 0;
                                ?>
                                @foreach($array1 as $link)
                                    @if($i % 15 == 0)
                                <div class="col-md-3 col-sm-6{{ $i == 15 ? ' right-line' : '' }}">
                                    @endif
                                    <a class="dropdown-item" href="{{ asset('view' . $link->href) }}">{{ $link->name }}</a>
                                    @if(($i + 1) % 15 == 0 || $i + 1 == count($array1))
                                        @if($i == 14 || $i == 29)
                                    <a class="bottom-line"></a>
                                        @endif
                                </div>
                                    @endif
                                    <?php $i++; ?>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown dropdown-extend{{ $is == 'ru' ? ' active' : '' }}">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        Синодальный перевод
                        <i class="fa fa-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-extend-menu dropdown-menu-dark" role="menu">
                        <div class="d-none d-lg-block">
                            <div class="row">
                                <?php
                                $i = 0;
                                $array2 = $is == 'greek' ? $navigation->otherBookLinks->bookLinks : $navigation->bookLinks;
                                ?>
                                @foreach($array2 as $link)
                                    @if(($i % 13 == 0 && $i != 52 && $i != 65) || $i == 50 || $i == 63)
                                        <div class="col-md-2"{!! $i == 39 ? ' style="border-right: 1px solid #d9d9d9"' : '' !!}>
                                    @endif
                                        <a class="dropdown-item" href="{{ asset('bible' . $link->href) }}">{{ $link->name }}</a>
                                    @if((($i + 1) % 13 == 0 && $i + 1 != 52 && $i + 1 != 65) || $i + 1 == 50 || $i + 1 == 63 || $i + 1 == count($array2))
                                        </div>
                                    @endif
                                    <?php $i++; ?>
                                @endforeach
                            </div>
                        </div>
                        <div class="d-md-block d-lg-none">
                            <div class="row">
                                <?php
                                $i = 0;
                                ?>
                                @foreach($array2 as $link)
                                    @if(($i % 20 == 0 && $i != 60) || $i == 57)
                                        <div class="col-md-3 col-sm-6">
                                    @endif
                                    @if($i == 50 || $i == 57)
                                        @if($i == 50)
                                        <a class="empty-block"></a>
                                        @endif
                                        <a class="bottom-line"></a>
                                    @endif
                                        <a class="dropdown-item" href="{{ asset('bible' . $link->href) }}">{{ $link->name }}</a>
                                    @if((($i + 1) % 20 == 0 && $i + 1 != 60) || $i + 1 == 57 || $i + 1 == count($array2))
                                        </div>
                                    @endif
                                    <?php $i++; ?>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown{{ $is == 'simphony-greek' || $is == 'simphony-ru' || $is == 'simphony-greek-word' ? ' active' : '' }}">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        Симфонии
                        <i class="fa fa-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-dark" role="menu">
                        <a class="dropdown-item" href="{{ asset('simphony-greek') }}">Греческо-русская симфония</a>
                        <a class="dropdown-item" href="{{ asset('simphony-ru') }}">Русско-греческая симфония</a>
                        <a class="dropdown-item" href="{{ asset('simphony-greek-word') }}">Симфония греческих словарных форм</a>
                    </div>
                </li>
                <li class="nav-item dropdown dropdown-extend{{ $is == 'comment' ? ' active' : '' }}">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        Комментарий
                        <i class="fa fa-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-extend-menu dropdown-menu-dark" role="menu">
                        <div class="d-none d-lg-block">
                            <div class="row">
                                <?php
                                $i = 0;
                                $array2 = $is == 'greek' ? $navigation->otherBookLinks->bookLinks : $navigation->bookLinks;
                                ?>
                                @foreach($array2 as $link)
                                    @if(($i % 13 == 0 && $i != 52 && $i != 65) || $i == 50 || $i == 63)
                                        <div class="col-md-2"{!! $i == 39 ? ' style="border-right: 1px solid #d9d9d9"' : '' !!}>
                                            @endif
                                            <a class="dropdown-item" href="{{ asset('comment' . $link->href) }}">{{ $link->name }}</a>
                                            @if((($i + 1) % 13 == 0 && $i + 1 != 52 && $i + 1 != 65) || $i + 1 == 50 || $i + 1 == 63 || $i + 1 == count($array2))
                                        </div>
                                    @endif
                                    <?php $i++; ?>
                                @endforeach
                            </div>
                        </div>
                        <div class="d-md-block d-lg-none">
                            <div class="row">
                                <?php
                                $i = 0;
                                ?>
                                @foreach($array2 as $link)
                                    @if(($i % 20 == 0 && $i != 60) || $i == 57)
                                        <div class="col-md-3 col-sm-6">
                                            @endif
                                            @if($i == 50 || $i == 57)
                                                @if($i == 50)
                                                    <a class="empty-block"></a>
                                                @endif
                                                <a class="bottom-line"></a>
                                            @endif
                                            <a class="dropdown-item" href="{{ asset('comment' . $link->href) }}">{{ $link->name }}</a>
                                            @if((($i + 1) % 20 == 0 && $i + 1 != 60) || $i + 1 == 57 || $i + 1 == count($array2))
                                        </div>
                                    @endif
                                    <?php $i++; ?>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item{{ $is == 'about' ? ' active' : '' }}">
                    <a href="{{ asset('about') }}" class="nav-link">
                        О программе
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>