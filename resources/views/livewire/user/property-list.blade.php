<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-5 g-xl-9">

    <div class="col-md-4">
        <div class="card h-md-100">
            <div class="card-body d-flex flex-center">
                <a type="button"
                   href="{{ route('user-management.properties.create') }}"
                   class="btn btn-clear d-flex flex-column flex-center">
                    <img src="{{ image('illustrations/sketchy-1/4.png') }}" alt="" class="mw-100 mh-150px mb-7"/>
                    <div class="fw-bold fs-3 text-gray-600 text-hover-primary">{{ __('menu.add_new_property') }}</div>
                </a>
            </div>
        </div>
    </div>
    @foreach($properties as $property)
        <div class="col-md-4">
            <div class="card card-flush h-md-100 shadow-sm">
                <div class="card-header">
                    <div class="card-title">
                        <h2 class="fs-4 fw-bold text-primary">{{ __('menu.property_number') }} #{{ $property->id }}</h2>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div class="text-gray-700">
                        <p><strong>{{ __('menu.owner') }}:</strong> {{ $property->property_owner }}</p>
                        <p><strong>{{ __('menu.ownership') }}:</strong>
                            <span class="badge {{ $property->ownership_type == 'owned' ? 'badge-light-success' : 'badge-light-warning' }}">
                                {{ $property->ownership_type == 'owned' ? __('menu.owned') : __('menu.rented') }}
                            </span>
                        </p>
                        <p><strong>{{ __('menu.address') }}:</strong> {{ $property->address }}</p>
                        <p><strong>{{ __('menu.floors') }}:</strong> {{ $property->floors_count ?? __('menu.na') }}</p>
                        <p><strong>{{ __('menu.residents') }}:</strong> {{ $property->residents_count }}</p>

                        @if($property->latitude && $property->longitude)
                            <p><strong>{{ __('menu.location') }}:</strong>
                                <a href="https://www.google.com/maps?q={{ $property->latitude }},{{ $property->longitude }}"
                                   target="_blank" class="text-primary">
                                    {{ __('menu.view_on_map') }}
                                </a>
                            </p>
                        @endif

                        @if($property->documents)
                            <p><strong>{{ __('menu.documents') }}:</strong>
                                <a href="{{ asset('storage/'.$property->documents) }}" target="_blank" class="text-success">
                                    {{ __('menu.view_file') }}
                                </a>
                            </p>
                        @endif
                    </div>

                    <hr>

                    <div class="fw-bold text-gray-600">
                        @if($property->report)
                            <span class="badge badge-light-success">{{ __('menu.report_submitted') }}</span>
                        @else
                            <span class="badge badge-light-danger">{{ __('menu.no_report_yet') }}</span>
                        @endif
                    </div>
                </div>
                <div class="card-footer flex-wrap pt-0">
                    {{-- تعديل الهوامش لتناسب RTL --}}
                    <a href="{{ route('user-management.properties.show', $property) }}" class="btn btn-light btn-active-primary my-1 {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}">
                        {{ __('menu.view') }}
                    </a>

                    <a href="{{ route('user-management.properties.edit', $property->id) }}"
                       class="btn btn-light btn-active-primary my-1 {{ app()->getLocale() == 'ar' ? 'ms-2' : 'me-2' }}">
                        {{ __('menu.edit') }}
                    </a>

                    <button
                        wire:click="deleteProperty({{ $property->id }})"
                        class="btn btn-light-danger my-1"
                        onclick="return confirm('{{ __('menu.delete_confirmation') }}')">
                        {{ __('menu.delete') }}
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>
