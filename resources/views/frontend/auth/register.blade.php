@extends('frontend.layouts.coreui')

@section('title', app_name() . ' | ' . __('labels.frontend.auth.register_box_title'))

@section('body_class', 'app flex-row align-items-center')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card mx-4">
                <div class="card-body p-4">
                    <h1>@lang('labels.frontend.auth.register_box_title')</h1>
                    <p class="text-muted">Create your account</p>
                    {{ html()->form('POST', route('frontend.auth.register.post'))->open() }}
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-user fa-fw"></i>
                            </span>
                        </div>
                        {{ html()->text('username')
                            ->class('form-control')
                            ->placeholder(__('validation.attributes.frontend.username'))
                            ->attribute('maxlength', 191)
                            ->required()}}
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-at fa-fw"></i></span>
                        </div>
                        {{ html()->email('email')
                            ->class('form-control')
                            ->placeholder(__('validation.attributes.frontend.email'))
                            ->attribute('maxlength', 191)
                            ->required() }}
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-unlock-alt fa-fw"></i>
                            </span>
                        </div>
                        {{ html()->password('password')
                            ->class('form-control')
                            ->placeholder(__('validation.attributes.frontend.password'))
                            ->required() }}
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-unlock fa-fw"></i>
                            </span>
                        </div>
                        {{ html()->password('password_confirmation')
                            ->class('form-control')
                            ->placeholder(__('validation.attributes.frontend.password_confirmation'))
                            ->required() }}
                    </div>
                    {{ form_submit(__('labels.frontend.auth.register_button'), 'btn btn-block btn-success') }}

                    {{ html()->form()->close() }}

                    @if ($socialiteLinks)
                    <div class="text-center">
                        {!! $socialiteLinks !!}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div><!-- row -->
@endsection
