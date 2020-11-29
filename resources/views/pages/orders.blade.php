@extends('master')

@section('title', 'Заказы')

@section('content')
    <div class="container">
        @if(empty($orders))
            <div class="row justify-content-center mt-5 mr-0 ml-0">
                <h5>У вас ещё нет заказов :(</h5>
            </div>
        @else
            <div class="row justify-content-center mt-4 mr-0 ml-0">
                <div class="h2 d-inline-block justify-content-center">История ваших заказов</div>
            </div>

            <div class="row pl-5 pr-5 pt-5 pb-0">

                <table class="table">
                    <thead>
                        <tr class="text-center">
                            <th class="border-0 text-uppercase small font-weight-bold">№</th>
                            <th class="border-0 text-uppercase small font-weight-bold">Дата оформления</th>
                            <th class="border-0 text-uppercase small font-weight-bold">Стоимость</th>
                            <th class="border-0 text-uppercase small font-weight-bold">Статус оплаты</th>
                            <th class="border-0 text-uppercase small font-weight-bold">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $key => $orderItem)
                        <tr class="text-center">
                            <td style="vertical-align: middle;">{{ $key + 1 }}</td>
                            <td style="vertical-align: middle;">{{ date("d.m.Y H:i", strtotime($orderItem['created_at'])) }}</td>
                            <td style="vertical-align: middle;">{{ number_format($orderItem['price'], 0, ',', ' ') }} ₽</td>
                            <td style="vertical-align: middle;">
                                {{ $orderItem['is_paid'] ? 'Оплачен' : 'Не оплачен' }}
                            </td>
                            <td style="vertical-align: middle;">
                                @if(!$orderItem['is_paid'])
                                <form method="post" action="{{ route('pay-order') }}"
                                      style="padding: 0; margin: 0; display: inline-block">
                                    @csrf
                                    <input type="hidden" name="orderId"
                                           value="{{ $orderItem['id'] }}"/>
                                    <button type="submit" class="btn" style="font-size: 20pt;"><i
                                            class="fa fa-money text-success"></i></button>
                                </form>
                                @endif

                                <form method="post" action="{{ route('delete-order') }}"
                                      style="padding: 0; margin: 0; display: inline-block">
                                    @csrf
                                    <input type="hidden" name="orderId"
                                           value="{{ $orderItem['id'] }}"/>
                                    <button type="submit" class="btn" style="font-size: 20pt;"><i
                                            class="fa fa-trash-o text-success"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                <form method="post" class="w-100" action="{{ route('clear-orders-history') }}">
                    @csrf
                    <button type="submit" class="btn btn-secondary float-right">Очистить историю заказов</button>
                </form>
            </div>
        @endif
    </div>
@stop
