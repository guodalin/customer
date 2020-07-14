@extends('backend.layouts.app')

@section('title', '编辑信息')

@section('content')
{{ html()
    ->modelForm($customer, 'patch', route('admin.customer.update', $customer))
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
                        <small class="text-muted">编辑信息</small>
                    </h4>
                </div><!--col-->
            </div><!--row-->
            <hr />
            @include('backend.customer.form')
        </div><!--card-body-->

        <div class="card-footer">
            <div class="row">
                <div class="col">
                    {{ form_cancel(route('admin.customer.index'), __('buttons.general.cancel')) }}
                </div><!--col-->

                <div class="col text-right">
                    {{ form_submit(__('buttons.general.crud.create')) }}
                </div><!--col-->
            </div><!--row-->
        </div><!--card-footer-->
    </div><!--card-->
{{ html()->form()->close() }}
@endsection
