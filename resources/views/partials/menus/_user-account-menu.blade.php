<div
    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
    data-kt-menu="true">
    <div class="menu-item px-3">
        <div class="menu-content d-flex align-items-center px-3">
            <div class="symbol symbol-50px {{ app()->getLocale() == 'ar' ? 'ms-5' : 'me-5' }}">
                @if(Auth::user()->profile_photo_url)
                    <img alt="Logo" src="{{ Auth::user()->profile_photo_url }}"/>
                @else
                    <div
                        class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', Auth::user()->name) }}">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
            </div>
            <div class="d-flex flex-column">
                <div class="fw-bold d-flex align-items-center fs-5">{{ Auth::user()->name}}
                    <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 {{ app()->getLocale() == 'ar' ? 'me-2' : 'ms-2' }}">
                        {{ __('menu.pro_label') }}
                    </span>
                </div>
                <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{ Auth::user()->email }}</a>
            </div>
        </div>
    </div>
    <div class="separator my-2"></div>

    <div class="menu-item px-5">
        <a href="{{route('user-management.users.show', \Illuminate\Support\Facades\Auth::id())}}"
           class="menu-link px-5">{{ __('menu.my_profile') }}</a>
    </div>

    <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
         data-kt-menu-placement="{{ app()->getLocale() == 'ar' ? 'right-start' : 'left-start' }}"
         data-kt-menu-offset="{{ app()->getLocale() == 'ar' ? '15px, 0' : '-15px, 0' }}">

        <a href="#" class="menu-link px-5">
        <span class="menu-title d-flex align-items-center justify-content-between w-100">
            <span>{{ __('menu.mode') }}</span>

            <span class="d-flex align-items-center">
                {!! getIcon('night-day', 'theme-light-show fs-2') !!}
                {!! getIcon('moon', 'theme-dark-show fs-2') !!}
            </span>
        </span>
        </a>

        @include('partials/theme-mode/__menu')
    </div>
    @php
        $currentLocale = app()->getLocale();
        $languages = [
            'en' => ['name' => 'English', 'flag' => 'flags/united-states.svg'],
            'ar' => ['name' => 'العربية', 'flag' => 'flags/saudi-arabia.svg']
        ];
        $displayLocale = $languages[$currentLocale] ?? $languages['en'];
    @endphp

    <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
         data-kt-menu-placement="{{ app()->getLocale() == 'ar' ? 'right-start' : 'left-start' }}"
         data-kt-menu-offset="{{ app()->getLocale() == 'ar' ? '15px, 0' : '-15px, 0' }}">

        <a href="#" class="menu-link px-5">
        <span class="menu-title position-relative">
            {{ __('menu.language') }}
            <span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 {{ app()->getLocale() == 'ar' ? 'start-0' : 'end-0' }}">
                {{ $displayLocale['name'] }}
                <img class="w-15px h-15px rounded-1 {{ app()->getLocale() == 'ar' ? 'me-2' : 'ms-2' }}" src="{{ image($displayLocale['flag']) }}" alt="flag"/>
            </span>
        </span>
        </a>

        <div class="menu-sub menu-sub-dropdown w-175px py-4">
            @foreach($languages as $code => $info)
                <div class="menu-item px-3">
                    <a href="{{ route('lang.switch', $code) }}"
                       class="menu-link d-flex px-5 {{ $currentLocale == $code ? 'active' : '' }}">
                    <span class="symbol symbol-20px {{ app()->getLocale() == 'ar' ? 'ms-4' : 'me-4' }}">
                        <img class="rounded-1" src="{{ image($info['flag']) }}" alt="{{ $info['name'] }}"/>
                    </span>
                        {{ $info['name'] }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="menu-item px-5">
        <a class="button-ajax menu-link px-5" href="#" data-action="{{ route('logout') }}" data-method="post"
           data-csrf="{{ csrf_token() }}" data-reload="true">
            {{ __('menu.sign_out') }}
        </a>
    </div>
</div>
