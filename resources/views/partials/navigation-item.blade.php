@php
    $children = $item['children'] ?? [];
    $isTopLevel = $depth === 0;
    $routeNames = (array) ($item['active'] ?? ($item['route'] ?? []));
    $matchesRoute = $routeNames !== [] && request()->routeIs(...$routeNames);
    $matchesParameters = true;

    foreach ($item['params'] ?? [] as $key => $value) {
        if (request()->route($key) !== $value) {
            $matchesParameters = false;
            break;
        }
    }

    $isActive = $matchesRoute && $matchesParameters;
@endphp

<li @class(['academy-nav-item', 'academy-nav-top' => $isTopLevel, 'academy-nav-nested' => ! $isTopLevel, 'active' => $isActive])>
    @if ($children !== [])
        <details class="academy-menu-group">
            <summary class="academy-menu-trigger">{{ __($item['label']) }} <i class="fa fa-angle-down" aria-hidden="true"></i></summary>
            <ul class="academy-menu-panel">
                @foreach ($children as $child)
                    @include('partials.navigation-item', ['item' => $child, 'depth' => $depth + 1])
                @endforeach
            </ul>
        </details>
    @else
        <a href="{{ route($item['route'], array_merge(['locale' => app()->getLocale()], $item['params'] ?? [])) }}" @if ($isActive) aria-current="page" @endif>{{ __($item['label']) }}</a>
    @endif
</li>
