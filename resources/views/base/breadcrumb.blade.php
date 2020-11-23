<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Главная</a></li>
        @if(isset($breadcrumb))
            @for($i = 0; $i < count($breadcrumb); ++$i)
                @if($i === (count($breadcrumb) - 1))
                    <li class="breadcrumb-item active">{{ $breadcrumb[$i][0] }}</li>
                @else
                    <li class="breadcrumb-item">
                        <a href="/catalog/{{ $breadcrumb[$i][1] }}">{{ $breadcrumb[$i][0] }}</a>
                    </li>
                @endif
            @endfor
        @endif
    </ol>
</nav>
