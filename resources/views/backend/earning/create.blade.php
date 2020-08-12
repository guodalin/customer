@extends('backend.layouts.app')

@section('title', '添加客服')

@section('content')
{{ html()
    ->form('post', route('admin.earning.store'))
    ->class('needs-validation')
    ->attribute('novalidate', true)
    ->acceptsFiles()
    ->open()
}}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        客服
                        <small class="text-muted">添加客服</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->
            <hr />
            @include('backend.earning.form')
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.earning.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.create')) }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
{{ html()->form()->close() }}
@endsection
