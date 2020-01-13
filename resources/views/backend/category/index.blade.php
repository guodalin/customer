@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.category.management'))

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.category.management') }}
                </h4>
            </div><!--col-->
        </div><!--row-->

        <category-gear el-class="mt-3"></category-gear>
    </div><!--card-body-->
</div><!--card-->
@endsection
