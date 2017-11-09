<div class="updates">
    <strong>
        Содержание
    </strong>
    <div class="row h-padding">
        <?php
        $class = $is == 'simphony-greek' || $is == 'simphony-greek-word' ? ' greek-font' : '';
        switch($is) {
            case 'simphony-greek':
                $url = '_greek';
                break;
            case 'simphony-ru':
                $url = '_ru';
                break;
            case 'simphony-greek-word':
                $url = '_greek-word';
                break;
        }
        ?>
    @for($i=0;$i<count($links);$i+=2)
        <div class="col-lg-2 simphony-class no-padding{{ $class . ($data[0]->code == $links[$i] ? ' active' : '') }}">
            <a class="action-class" data="{{ $url }}" href="{{ asset('simphony-' . (explode('_', $url)[1]) . '?word=' . $links[$i]) }}">{{ $links[$i+1] }}</a>
        </div>
    @endfor
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