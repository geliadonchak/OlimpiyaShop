<nav class="container-fluid navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ route('home') }}">Olimpiya </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            @if(isset($categories))
                @foreach($categories as $category)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{ route('catalog', $category->id) }}"
                           id="navbarDropdown" role="button"
                           data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            {{ $category->name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach($category->children as $subcategory)
                                <a class="dropdown-item"
                                   href="{{ route('catalog', $subcategory->id) }}">{{ $subcategory->name }}</a>
                            @endforeach
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('catalog', $category->id) }}">Все товары
                                категории</a>
                        </div>
                    </li>
                @endforeach
            @endif
            <li class="nav-item">
                <a class="nav-link" href="#">Корзина
                    <span class="badge badge-success badge-pill">0</span>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav mr-0">
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Поиск" aria-label="Поиск">
                <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Поиск</button>
            </form>
            <li class="nav-item">
                @if(\Illuminate\Support\Facades\Auth::check())
                    <a class="btn btn-outline-success ml-2" href="{{ route('logout') }}">Выйти</a>
                @else
                    <a class="btn btn-outline-success ml-2" href="{{ route('login') }}">Войти</a>
                @endif
            </li>
        </ul>
    </div>
</nav>
