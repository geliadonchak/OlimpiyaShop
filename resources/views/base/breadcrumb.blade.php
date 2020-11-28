@if(isset($breadcrumb))
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            @for($i = 0, $iMax = count($breadcrumb); $i < $iMax; ++$i)
                @if($i === (count($breadcrumb) - 1))
                    <li class="breadcrumb-item active">{{ $breadcrumb[$i][0] }}</li>
                @elseif(is_int($breadcrumb[$i][0]))
                    <li class="breadcrumb-item">
                        <a href="/{{ $breadcrumb[$i][1] }}">{{ $breadcrumb[$i][0] }}</a>
                    </li>
                @else
                    <li class="breadcrumb-item">
                        <a href="/catalog/{{ $breadcrumb[$i][1] }}">{{ $breadcrumb[$i][0] }}</a>
                    </li>
                @endif
            @endfor
        </ol>
    </nav>
@endif
