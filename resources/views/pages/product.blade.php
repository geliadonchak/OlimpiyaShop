@extends('master')

@section('title', "$currentProduct->name")

@section('content')
    <div class="container">
        <section class="my-5">
            <div class="row">
                <div class="col-md-5 mb-4 mb-md-0">

                    <div class="view zoom z-depth-2 rounded">
                        <img class="img-fluid w-100" style="height: 800px; object-fit: contain" src="{{ "/storage" . $currentProduct->image }}" alt="">
                    </div>

                </div>
                <div class="col-md-7">
                    <h2>{{ $currentProduct->name }}</h2>
                    <p class="mb-2 text-muted text-uppercase small">{{$currentProductCategory}}</p>
                    <ul class="list-group list-group-horizontal mb-3">
                        @for($i = 0; $i < $currentProduct->rating; ++$i)
                            <li class="list-item mr-2">
                                <i class="fa fa-star fa-sm text-success"></i>
                            </li>
                        @endfor

                        @for($i = 0; $i < 5 - $currentProduct->rating; ++$i)
                            <li class="list-item mr-2">
                                <i class="fa fa-star-o fa-sm text-success"></i>
                            </li>
                        @endfor
                    </ul>
                    <div class="h4">
                        <strong>{{ number_format($currentProduct->price, 0, ',', ' ') }}</strong><small><strong>
                                ₽</strong></small></div>
                    <p class="pt-1">{{ preg_replace('/&nbsp;/', ' ', $currentProduct->description) }}</p>
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless mb-0">
                            <tbody>
                            @foreach($attributes as $attr)
                                <tr>
                                    <th class="pl-0 w-25" scope="row"><strong>{{ $attr->name }}</strong></th>
                                    <td>{{ $attr->value }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr>

                    @if(\Illuminate\Support\Facades\Auth::check())
                        <form method="post" action="{{ route('add-product-to-basket') }}">
                            <div class="text-muted"><p class="mb-1">Количество</p></div>

                            <div class="row mb-2">
                                <div class="col-5 input-group mb-0">
                                    <button type="button" class="btn btn-outline-danger mr-2"
                                            onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                        &#8722;
                                    </button>
                                    <input class="form-control" name="count" min="1" value="1" type="number">
                                    <button type="button" class="btn btn-outline-success ml-2"
                                            onclick="this.parentNode.querySelector('input[type=number]').stepUp()">&#43;
                                    </button>
                                </div>
                            </div>

                            @csrf
                            <input type="hidden" name="productId" value="{{$currentProduct->id}}"/>
                            <button type="submit" class="btn btn-secondary mt-4">В корзину</button>
                        </form>
                    @endif
                </div>
            </div>
        </section>
    </div>
@stop
