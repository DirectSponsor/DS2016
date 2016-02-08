<div id='menu_nav' class='bottom-border-light'>
    <ul class="nav nav-pills">
        <li ><a class="text-warning" href="#">Menu</a></li>
        @foreach($links as $link)
            <?php
                $uri = str_replace("/", "", Request::path());
                if (strlen($uri) < 50) {
                    $length = strlen($uri) * -1;
                } else {
                    $length = -50;
                }
                $endOfLink = str_replace("/", "", substr($link['link'], $length));
                if (stristr($uri, $endOfLink)) {
                    $setClassActive = 'active';
                } else {
                    $setClassActive = '';
                }
            ?>
            <li class="{!! $setClassActive !!}"><a href="{!! $link['link'] !!}">{!! $link['name'] !!}</a></li>
        @endforeach
    </ul>
</div>