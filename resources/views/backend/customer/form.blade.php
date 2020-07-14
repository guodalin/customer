<div class="form-group row">
    {{ html()->label('姓名')->class('col-2 col-form-label required') }}
    <div class="col-4">
        {{ html()->text('name')->class(['form-control', 'is-invalid' => $errors->has('name')]) }}
        <small class="invalid-feedback">
            @if ($errors->has('name'))
                {{ $errors->first('name') }}
            @else
                @lang('labels.validations.url')
            @endif
        </small>
    </div>
</div>

<div class="form-group row">
    {{ html()->label('简介')->class('col-2 col-form-label') }}
    <div class="col-4">
        {{ html()
            ->textarea('info')
            ->class('form-control')
            ->placeholder('简介')
            ->autofocus()
        }}
    </div>
</div>
<div class="form-group row">
    <label class="col-md-3 col-form-label" for="file-input">头像</label>
    <div class="col-md-9">
        @if (isset($customer))
        <div class="mb-3">
            {{ html()->hidden('avatar') }}
            <img src="{{ asset('storage/'.$customer->avatar) }}" width="200" class="rounded img-fluid">
        </div>
        @endif
        <input id="file-input" type="file" name="avatar">
    </div>
</div>
{{--  <div class="form-group row">
    {{ html()->label(__('labels.general.cover'))->class('col-2 col-form-label')->for('media') }}
    <div class="col-8">
        @if (isset($hospital))
        <div class="mb-3">
            {{ html()->hidden('cover') }}
            <img src="{{ $hospital->cover }}" class="rounded img-fluid">
        </div>
        <div class="w-100"></div>
        @endif
        <div class="row">
            <div class="col-6">
                <div class="custom-file">
                    {{ html()->file('media')->class(['custom-file-input', 'is-invalid' => $errors->has('media')]) }}
                    {{ html()->label(__('labels.general.placeholders.file'))->class('custom-file-label') }}
                    <small class="invalid-feedback">
                        @if ($errors->has('media'))
                            {{ $errors->first('media') }}
                        @endif
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>  --}}
