@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.menu.management'))

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.menu.management') }}
                </h4>
            </div><!--col-->
        </div><!--row-->

        <menu-gear el-class="mt-3"></menu-gear>
    </div><!--card-body-->
</div><!--card-->
@endsection
