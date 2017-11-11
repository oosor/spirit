<div class="title">
    @for($i=0;$i<count($data->a_1->data);$i++)
        {!! $i == 8 ? '</div>' : '' !!}
        @if(empty($data->a_1->data[$i]))
            {!! $i < 9 ? '' : '<br>' !!}
            @continue
        @endif
        <div class="word-block">
            <span class="word greek-word{{ (ctype_digit($data->a_1->data[$i])) ? (' digit' . ($i < 8 ? ' chapter' : '')) : '' }}" data="{{ $data->a_3->data[$i] }}">{!! $data->a_1->data[$i] !!}</span>
            <span class="word ru-word" data="{{ $data->a_4->data[$i] }}">{!! $data->a_4->data[$i] !!}</span>
        </div>
    @endfor