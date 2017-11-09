<div class="load">
    <?php
    $arStr = explode('_', $data->code);
    $book = $CONST->BOOK_FULL_NAMES_RU[(int) $arStr[0] - 1];
    $chapter = (int) $arStr[1] == 0 ? '(Предисловие)' : (int) $arStr[1];
    ?>
    <h5 class="greek-chapter ru-bible" data="{{ $data->code }}">{{ $book . ' ' . $chapter }}</h5>
    {!! $data->text !!}
</div>