@extends('master')

@section('title', (string) $currentCategory->name)

@section('content')
    <div class="container-fluid">
        <div class="row">
            @if(count($currentCategory->children) > 0)
                <div class="col-2 m-0 p-0 flex-column">
                    <div class="row m-0 p-3" style="background-color: #e9ecef">
                        <h4 class="d-flex justify-content-center align-items-center mt-3 text-dark w-100"><span>Подкатегории<hr></span>
                        </h4>

                        <ul class="nav flex-column">
                            @foreach($currentCategory->children as $key => $categoryItem)
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="/catalog/{{ $categoryItem->id }}">
                                        {{ $categoryItem->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @else
                <div class="col-2 m-0 p-0 flex-column"></div>
            @endif

            <div class="col-10 m-0">
                <div class="row justify-content-center mt-4 mr-0 ml-0">
                    <div class="h2 d-inline-block justify-content-center">{{ $currentCategory->name }}</div>
                </div>
                @if(count($currentCategory->products) > 0)
                    <div class="row justify-content-center mt-4 mr-0 ml-0">
                        <div class="row justify-content-center">
                            @foreach($currentCategory->products as $key => $product)
                                <form method="post" action="{{ route('add-product-to-basket') }}">
                                    <div class="card mb-3 mt-3 mr-3 ml-3 justify-content-center" style="width: 18rem;">
                                        <img class="container-fluid mt-3 card-img-top"
                                             src="{{ "/storage" . $product->image }}" style="height: 180px"
                                             alt="">
                                        <div class="card-body">
                                            <h5 class="card-title" style="min-height: 5rem">{{ $product->name }}</h5>
                                            <div class="h4 text-right">
                                                <strong>{{ number_format($product->price, 0, ',', ' ') }}</strong>
                                                <small><strong>₽</strong></small>
                                            </div>
                                            <div class="row">
                                                <input @if(!\Illuminate\Support\Facades\Auth::check()) disabled @endif type="submit" class="btn btn-success mr-1 ml-1 mb-0" value="В корзину"/>
                                                <a href="/product/{{ $product->id }}"
                                                   class="btn btn-secondary mr-1 ml-1 mb-0">Перейти к товару</a>
                                            </div>
                                        </div>

                                        @csrf
                                        <input type="hidden" name="productId" value="{{$product->id}}" />
                                        <input type="hidden" name="count" value="1" />
                                    </div>
                                </form>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="row justify-content-center mt-4 mr-0 ml-0">
                        <div class="row justify-content-center">
                            <h5>Нет товаров в категории</h5>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop

