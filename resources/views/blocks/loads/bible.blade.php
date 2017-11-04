<div class="title">
    <h5 class="greek-chapter ru-bible" data="{{ $data->ot_nt . '/' . $data->book . '/' . $data->chapter }}">{{ $data->t }}</h5>
@foreach($data->a->data as $el)
    <div>
    <?php
    $arr = explode(' ', $el);
    ?>
    @foreach($arr as $index=>$ar)
    @if($index == 0)
        {!! $ar !!}
        @continue
    @elseif($index == 1)
        {!! ' data="' . ($data->ot_nt . '/' . $data->book . '/' . $data->chapter) . '" ' . $ar !!}
        @continue
    @elseif($index == 2)
        {!! ' ' . $ar !!}
        @continue
    @else
        {!! ' <a class="simphony-ru no-modal">' . $ar . '</a>' !!}
    @endif
    @endforeach
    </div>
@endforeach
</div>