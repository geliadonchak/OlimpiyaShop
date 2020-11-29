@extends('master')

@section('title', "Корзина")

@section('scripts')
    <script>
        $(document).ready(() => {
            $('a[href="{{route('logout')}}"]').remove();
        });
    </script>
@overwrite

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 pr-4">
                <div class="mb-3">
                    <div class="pt-4">
                        <h4 class="mb-5">Товаров в корзине: {{ count($basketItems) }}</h4>

                        @if(empty($basketItems))
                            <h5>Корзина пуста :(</h5>
                        @endif


                        @foreach($basketItems as $basketItem)
                            <div class="row mb-4">
                                <div class="col-md-5 col-lg-3 col-xl-3">
                                    <div class="mb-3 mb-md-0">
                                        <img class="img-fluid w-100"
                                             src="{{ "/storage" . $basketItem['product']['image'] }}"
                                        >
                                    </div>
                                </div>
                                <div class="col-md-7 col-lg-9 col-xl-9">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="mb-3">{{ $basketItem['product']['name'] }}</h5>
                                            <p class="mr-3"
                                               style="overflow: hidden; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical;">{{ $basketItem['product']['description'] }}</p>
                                        </div>
                                        <div>
                                            <small class="form-text text-muted text-right">
                                                Количество:
                                            </small>
                                            <p class="text-right"><strong>{{ $basketItem['count'] }}</strong></p>
                                            <small class="form-text text-muted text-right">
                                                Цена:
                                            </small>
                                            <p class="text-right">
                                                <strong>{{ number_format($basketItem['product']['price'], 0, ',', ' ') }}
                                                    ₽</strong>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mb-0 mt-4" style="font-size: 30px; display: inline-block;">
                                        <form method="post" action="{{ route('remove-product-from-basket') }}"
                                              style="padding: 0; margin: 0;">
                                            @csrf
                                            <input type="hidden" name="productId"
                                                   value="{{$basketItem['product']['id']}}"/>
                                            <button type="submit" class="btn" style="font-size: 20pt;"><i
                                                    class="fa fa-trash-o text-success"></i></button>
                                        </form>
                                    </div>
                                    <a class="btn" href="{{ route('product', $basketItem['product']['id']) }}" style="font-size: 17pt"><i class="fa fa-external-link text-success"></i></a>
                                </div>
                            </div>

                            <hr class="mb-4">
                        @endforeach
                    </div>


                    @if(!empty($basketItems))
                        <div>
                            <form method="post" action="{{ route('remove-all-products-from-basket') }}">
                                @csrf
                                <button type="submit" class="btn btn-secondary float-right">Удалить все товары</button>
                            </form>
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <div class="pt-5">
                        <h6 class="mb-2 text-muted">Мы принимаем оплату</h6>
                        <img class="mr-2" width="45px"
                             src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/visa.svg"
                             alt="Visa">
                        <img class="mr-2" width="45px"
                             src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/mastercard.svg"
                             alt="Mastercard">
                        <img class="mr-2" width="45px"
                             src="https://mdbootstrap.com/wp-content/plugins/woocommerce/includes/gateways/paypal/assets/images/paypal.png"
                             alt="PayPal acceptance mark">
                    </div>
                </div>

            </div>

            @if(!empty($basketItems))
                <div class="col-lg-4 pl-4">

                    <div class="mb-3">
                        <div class="pt-4">
                            <h4 class="mb-5">Общая стоимость</h4>

                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 p-0 m-0">
                                    Товары
                                    <span>{{ number_format($priceSum, 0, ',', ' ') }} ₽</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center pt-0 px-0 pb-3 m-0">
                                    Доставка
                                    <span>{{ number_format($deliveryPrice, 0, ',', ' ') }} ₽</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                                    <div>
                                        <strong>Итого</strong>
                                    </div>
                                    <span><strong>{{ number_format($priceSum + $deliveryPrice, 0, ',', ' ') }} ₽</strong></span>
                                </li>
                            </ul>
                            <form method="post" action="{{ route('add-basket-to-order') }}">
                                @csrf
                                <button type="submit" class="btn btn-success btn-block">Оформить заказ</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@stop

