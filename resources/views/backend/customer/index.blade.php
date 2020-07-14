@extends ('backend.layouts.app')
@section ('title', app_name() . ' | 客服' )
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    客服
                </h4>
            </div>
            <!--col-->
            <div class="col-sm-7 pull-right">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                    <a href="{{ route('admin.customer.create') }}" class="btn btn-success ml-1" data-toggle="tooltip" title="Create New"><i class="fas fa-plus-circle"></i></a>
                </div>
            </div>
            <!--col-->
        </div>
        <!--row-->
        <div class="row">
            <div class="col">
                {{ html()->form('get', route('admin.customer.index'))->class('form-inline')->open() }} {{ html() ->text('q') ->placeholder('名称')
                ->class('form-control mb-2 mr-sm-2') ->value(isset($search['q']) ? $search['q'] : '') }} {{ html()->submit('搜索')->class('btn
                btn-primary mb-2') }} {{ html()->form()->close() }}
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>姓名</th>
                                <th>头像</th>
                                <th>@lang('labels.general.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>
                                    {{ $customer->name }}
                                </td>
                                <td>
                                    <div class="media">
                                        <img src="{{ asset('storage/'.$customer->avatar) }}" alt="" class="mr-3 rounded" width="120">
                                    </div>
                                </td>
                                <td>
                                    <div role="group" aria-label="lecture Actions" class="btn-group">
                                        <a href="{{ route('admin.customer.edit', $customer) }}" class="btn btn-primary"><i class="far fa-edit fa-fw" data-toggle="tooltip" data-placement="top" title="{{ __('buttons.general.crud.edit') }}"></i>编辑</a>
                                        <a href="{{ route('admin.customer.destroy', $customer) }}" data-method="delete" data-trans-button-cancel="{{ __('buttons.general.cancel') }}"
                                            data-trans-button-confirm="{{ __('buttons.general.crud.delete') }}" data-trans-title="{{ __('strings.backend.general.are_you_sure') }}"
                                            class="btn btn-danger"><i class="far fa-trash-alt fa-fw" data-toggle="tooltip" data-placement="top" title="{{ __('buttons.general.crud.delete') }}"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!--col-->
        </div>
        <!--row-->
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    {{ $customers->total() }}
                </div>
            </div>
            <!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $customers->appends($search)->render() !!}
                </div>
            </div>
            <!--col-->
        </div>
        <!--row-->
    </div>
    <!--card-body-->
</div>
<!--card-->
@endsection
