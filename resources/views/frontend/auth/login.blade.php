@extends('frontend.layouts.coreui')

@section('body_class', 'app flex-row align-items-center')

@section('title', app_name() . ' | ' . __('labels.frontend.auth.login_box_title'))

@section('content')
<div class="row justify-content-end">
    <div class="{{ config('access.registration') ? 'col-md-8 col-lg-8' : 'col-md-6 col-lg-4' }}">
        <div class="card-group">
            <div class="card p-4">
                <div class="card-body">
                    <h1>@lang('labels.frontend.auth.login_box_title')</h1>
                    <p class="text-muted">Sign In to your account</p>
                    {{ html()->form('POST', route('frontend.auth.login.post'))->open() }}
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-user"></i>
                            </span>
                        </div>
                        {{ html()->text(config('access.users.username'))
                            ->class('form-control')
                            ->placeholder(__('validation.attributes.frontend.' . config('access.users.username')))
                            ->attribute('maxlength', 191)
                            ->required() }}
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                        </div>
                        {{ html()->password('password')
                            ->class('form-control')
                            ->placeholder(__('validation.attributes.frontend.password'))
                            ->required() }}
                    </div>
                    <div class="custom-control custom-checkbox mb-3">
                        {{ html()->checkbox('remember', true, 1)->class('custom-control-input') }}
                        {{ html()->label(__('labels.frontend.auth.remember_me'))->for('remember')->class('custom-control-label') }}
                    </div>
                    <!--form-group-->
                    <div class="row">
                        <div class="col-6">
                            {{ form_submit(__('labels.frontend.auth.login_button'), 'btn btn-primary px-4') }}
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('frontend.auth.password.reset') }}" class="btn btn-link px-0">@lang('labels.frontend.passwords.forgot_password')</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                {!! $socialiteLinks !!}
                            </div>
                        </div>
                        <!--col-->
                    </div>
                    <!--row-->
                    {{ html()->form()->close() }}
                </div>
            </div>
            @if (config('access.registration'))
            <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
                <div class="card-body text-center">
                    <div>
                        <h2>@lang('labels.frontend.auth.register_box_title')</h2>
                        <p>@lang('strings.frontend.access.register_helper')</p>
                        <a href="{{ route('frontend.auth.register') }}" class="btn btn-primary active mt-3">@lang('buttons.frontend.auth.register_now')</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
