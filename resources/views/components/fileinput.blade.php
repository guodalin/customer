<div class="fileinput fileinput-new {{ $class ?? '' }}" data-provides="fileinput">
    <div class="fileinput-{{ isset($image) ? 'new' : 'preview' }} thumbnail" data-trigger="fileinput" style="width: {{ $width ?? '200px' }}; height: {{ $height ?? '150px' }};">
        @isset($image)
            <img src="{{ $image }}" alt="">
        @endisset
    </div>

    @isset($image)
        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: {{ $width ?? '200px' }}; max-height: {{ $height ?? '150px' }};"></div>
    @endisset

    <div class="text-center">
        <span class="btn btn-outline-secondary btn-file">
            <span class="fileinput-new">@lang('buttons.components.fileinput.browse')</span>
            <span class="fileinput-exists">@lang('buttons.components.fileinput.change')</span>
            <input type="file" name="{{ $file ?? 'file' }}">
        </span>
        <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">@lang('buttons.components.fileinput.remove')</a>
    </div>
</div>
