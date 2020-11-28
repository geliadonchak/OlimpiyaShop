@extends('master')

@section('title', "Подтверждение пароля")

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Подтверждение пароля') }}</div>

                    <div class="card-body">
                        {{ __('Пожалуйста, подтвердите свой пароль перед тем как продолжить.') }}

                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Пароль') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                 Примечание: обычно вы можете сгруппировать все маршруты, требующие аутентификации, вместе с authпромежуточным ПО. Для этой демонстрации мы создаем один маршрут контроллера в Settingsпространстве имен.

                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Подтвердить пароль') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Забыли пароль?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
