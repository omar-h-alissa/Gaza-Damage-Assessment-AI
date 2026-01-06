<x-default-layout>

    @section('title')
        {{ isset($property) ? __('menu.edit_property') . ': ' . $property->property_owner : __('menu.add_property') }}
    @endsection

    <div id="kt_app_content_container" class="app-container container-xxl">

        <div class="card mt-10">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <h2 class="fw-bold mb-0">
                        {{ isset($property) ? __('menu.edit_property_details') : __('menu.add_new_property') }}
                    </h2>
                </div>
            </div>

            <div class="card-body pt-0">
                <form action="{{ isset($property) ? route('user-management.properties.update', $property->id) : route('user-management.properties.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @if(isset($property))
                        @method('PUT')
                    @endif

                    {{-- مالك العقار --}}
                    <div class="mb-7">
                        <label class="required form-label">{{ __('menu.property_owner') }}</label>
                        <input type="text" name="property_owner" class="form-control form-control-solid"
                               placeholder="{{ __('menu.owner_name_placeholder') }}" required
                               value="{{ old('property_owner', $property->property_owner ?? '') }}"/>
                    </div>

                    {{-- نوع الملكية --}}
                    <div class="mb-7">
                        @php
                            $selectedOwnership = old('ownership_type', $property->ownership_type ?? '');
                        @endphp
                        <label class="required form-label">{{ __('menu.ownership_type') }}</label>
                        <select name="ownership_type" class="form-select form-select-solid" required>
                            <option value="">-- {{ __('menu.select_option') }} --</option>
                            <option value="owned" {{ $selectedOwnership == 'owned' ? 'selected' : '' }}>{{ __('menu.owned') }}</option>
                            <option value="rented" {{ $selectedOwnership == 'rented' ? 'selected' : '' }}>{{ __('menu.rented') }}</option>
                        </select>
                    </div>

                    {{-- العنوان --}}
                    <div class="mb-7">
                        <label class="required form-label">{{ __('menu.address') }}</label>
                        <input type="text" name="address" class="form-control form-control-solid"
                               placeholder="{{ __('menu.address_placeholder') }}" required
                               value="{{ old('address', $property->address ?? '') }}"/>
                    </div>

                    {{-- الطوابق والسكان --}}
                    <div class="row mb-7">
                        <div class="col-md-6">
                            <label class="form-label">{{ __('menu.floors_count') }}</label>
                            <input type="number" name="floors_count" class="form-control form-control-solid"
                                   placeholder="{{ __('menu.floors_placeholder') }}"
                                   value="{{ old('floors_count', $property->floors_count ?? '') }}"/>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('menu.residents_count') }}</label>
                            <input type="number" name="residents_count" class="form-control form-control-solid"
                                   placeholder="{{ __('menu.residents_placeholder') }}"
                                   value="{{ old('residents_count', $property->residents_count ?? '') }}"/>
                        </div>
                    </div>

                    {{-- وثائق العقار --}}
                    <div class="fv-row mb-7">
                        <label class="fs-5 fw-bold mb-2">{{ __('menu.property_document') }}</label>
                        <input type="file" class="form-control form-control-solid" name="documents" >
                        <small class="text-muted">{{ __('menu.allowed_formats') }}</small>
                        @error('documents') <span class="text-danger">{{ $message }}</span> @enderror

                        @if(isset($property) && $property->documents)
                            <p class="mt-2">
                                {{ __('menu.current_document') }}:
                                <a href="{{ asset('storage/' . $property->documents) }}" target="_blank">{{ __('menu.view_file') }}</a>
                            </p>
                            <small class="text-warning">{{ __('menu.keep_file_hint') }}</small>
                        @endif
                    </div>

                    {{-- الخريطة --}}
                    <div class="mb-7">
                        <label class="form-label fw-bold mb-2">{{ __('menu.select_location') }}</label>
                        <div id="map" style="height: 400px; width: 100%; border-radius: 10px;"></div>
                        <input type="hidden" id="latitude" name="latitude" value="{{ $property->latitude ?? 31.5 }}">
                        <input type="hidden" id="longitude" name="longitude" value="{{ $property->longitude ?? 34.4667 }}">
                    </div>

                    {{-- الأزرار --}}
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('user-management.properties.index') }}" class="btn btn-light me-3">{{ __('menu.cancel') }}</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ki-duotone ki-save-2 fs-3 me-2"></i>
                            {{ isset($property) ? __('menu.update_property') : __('menu.save_property') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Leaflet CSS/JS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const initialLat = parseFloat(document.getElementById('latitude').value);
            const initialLng = parseFloat(document.getElementById('longitude').value);

            const map = L.map('map').setView([initialLat, initialLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            let marker = L.marker([initialLat, initialLng], {draggable: true}).addTo(map);

            marker.on('dragend', function(e) {
                const {lat, lng} = e.target.getLatLng();
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
            });

            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                document.getElementById('latitude').value = e.latlng.lat;
                document.getElementById('longitude').value = e.latlng.lng;
            });

            // الجلب التلقائي للموقع فقط في حالة الإضافة الجديدة
            if (!{{ isset($property) ? 'true' : 'false' }} && navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(pos => {
                    const {latitude, longitude} = pos.coords;
                    map.setView([latitude, longitude], 15);
                    marker.setLatLng([latitude, longitude]);
                    document.getElementById('latitude').value = latitude;
                    document.getElementById('longitude').value = longitude;
                });
            }
        });
    </script>

</x-default-layout>
