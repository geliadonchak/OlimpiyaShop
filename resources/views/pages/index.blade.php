@extends('master')

@section('title', 'Главная')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-xl-8">
                <div id="mainCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('images/carousel (fitness).jpg') }}" class="d-block w-100" alt=""
                                 style="height: 300px;">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/carousel (active sport).jpg') }}" class="d-block w-100" alt=""
                                 style="height: 300px;">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/carousel (yoga).png') }}" class="d-block w-100" alt=""
                                 style="height: 300px;">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#mainCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#mainCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="h3 d-inline-block justify-content-center">Мы рекомендуем</div>

            <div class="row justify-content-center">
                @foreach($products as $key => $product)
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
    </div>
@stop
