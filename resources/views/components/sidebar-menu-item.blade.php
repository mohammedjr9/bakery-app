@php
    $children = $sidebarMenu->filter(function ($sub) use ($item) {
        return $sub->follow_to_id == $item->id && $sub->id != $item->id;
    });

    $canAccess = true;
    if (!empty($item->permission)) {
        $canAccess = auth()->user()->can($item->permission);
    }

    $hasActiveChild = $children->contains(function ($sub) {
        return request()->routeIs($sub->url);
    });

    $isActive = request()->routeIs($item->url) || $hasActiveChild;
@endphp

@if ($canAccess)
    @if ($children->isNotEmpty())
        {{-- عنصر له أبناء --}}
        <li class="menu-item {{ $isActive ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-circle-dashed"></i>
                <div>{{ $item->name }}</div>
            </a>
            <ul class="menu-sub">
                @foreach ($children as $sub)
                    @include('components.sidebar-menu-item', ['item' => $sub, 'sidebarMenu' => $sidebarMenu])
                @endforeach
            </ul>
        </li>
    @else
        {{-- عنصر بدون أبناء: رابط فعلي --}}
        @if (Route::has($item->url))
            <li class="menu-item {{ request()->routeIs($item->url) ? 'active' : '' }}">
                <a href="{{ route($item->url) }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-circle"></i>
                    <div>{{ $item->name }}</div>
                </a>
            </li>
        @endif
    @endif
@endif
