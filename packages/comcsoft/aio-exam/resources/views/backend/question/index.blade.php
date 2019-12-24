@extends ('backend.layouts.app')

@section ('title', app_name() . ' | '. __('aio-exam::backend.menu.titles.question'))

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    @lang('aio-exam::backend.menu.titles.question')
                </h4>
            </div>
            <!--col-->

            <div class="col-sm-7 pull-right">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                @foreach (config('aio.exam.types.question') as $type)
                    <a href="{{ route('aio-exam::admin.question.create', ['type' => $type]) }}" class="btn btn-success ml-1" data-toggle="tooltip">@lang('buttons.general.crud.create') @lang('aio-exam::labels.types.question.' . $type)</a>
                @endforeach
                </div>
            </div>
            <!--col-->
        </div>
        <!--row-->
        <div class="row">
            <div class="col">
                @include('aio-exam::backend.question.includes.search_form')
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="100">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="check-all" data-target=".check-all">
                                        <label class="custom-control-label" for="check-all">#</label>
                                    </div>
                                </th>
                                <th>题干</th>
                                <th>类型</th>
                                <th width="150">分类</th>
                                <th width="150">时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($questions as $q)
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        {{ html()->checkbox('bucket[]')->class('custom-control-input check-all bucket-question-item')->id('question-id-'.$q->id)->value($q->id) }}
                                        <label class="custom-control-label" for="question-id-{{ $q->id }}">{{ $q->id }}</label>
                                    </div>
                                </td>
                                <td>{{ $q->name }}</td>
                                <td>{!! $q->type_badge !!}</td>
                                <td>{{ $q->category ? $q->category->name : '' }} </td>
                                <td>
                                    创建: {{ $q->created_at->diffForHumans() }} <br>
                                    修改: {{ $q->updated_at->diffForHumans() }}
                                </td>
                                <td>
                                    <div role="group" class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.e.questions.edit', $q) }}" class="btn btn-primary">
                                            <i class="far fa-edit" data-toggle="tooltip" data-placement="top" title="{!! __('buttons.general.crud.edit') !!}"></i>
                                        </a>
                                        <a href="{{ route('admin.e.questions.destroy', $q) }}" data-method="delete" data-trans-button-cancel="{{ __('buttons.general.cancel') }}" data-trans-button-confirm="{{ __('buttons.general.crud.delete') }}" data-trans-title="{{ __('strings.backend.general.are_you_sure') }}" class="btn btn-danger">
                                            <i class="far fa-trash-alt" data-toggle="tooltip" data-placement="top" title="{{ __('buttons.general.crud.delete') }}"></i>
                                        </a>
                                        <a href="{{ route('admin.e.buckets.add', $q) }}" class="btn btn-success btn-add-to-bucket">
                                            <i class="fas fa-cart-plus" data-toggle="tooltip" data-placement="top" title="添加到题蓝"></i>
                                        </a>
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
        <div class="row mb-2">
            <div class="col-12">
                <button type="button" class="btn btn-warning btn-batch-add-bucket" data-target=".bucket-question-item"><i class="fas fa-cart-plus"></i> 加入题篮</button>
            </div>
        </div>
        <!--row-->
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    {{ trans_choice('题目统计', $questions->total()) }}{!! $questions->total() !!}
                </div>
            </div>
            <!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $questions->appends($search)->render() !!}
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
