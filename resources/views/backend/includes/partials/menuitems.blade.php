@foreach ($items as $item)
    @if ($item->attr('class') == 'nav-title')
    <li class="nav-title">
        {{ $item->title }}
    </li>
    @else
    <li @lm_attrs($item) class="nav-item @if($item->hasChildren()) nav-dropdown @endif" @lm_endattrs>
        @if($item->link)
        <a @lm_attrs($item->link) @if($item->hasChildren()) class="nav-link nav-dropdown-toggle" @else class="nav-link" @endif @lm_endattrs href="{!! $item->url() !!}">
            {!! $item->title !!}
        </a>
        @else
        <span class="navbar-text">{!! $item->title !!}</span>
        @endif

        @if($item->hasChildren())
        <ul class="nav-dropdown-items">
            @include(config('laravel-menu.views.bootstrap-items'), ['items' => $item->children()])
        </ul>
        @endif
    </li>
    @endif

    @if($item->divider)
    <li {!! Lavary\Menu\Builder::attributes($item->divider) !!}></li>
    @endif
@endforeach
