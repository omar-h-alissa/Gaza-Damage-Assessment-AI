<x-default-layout>

    @section('title')
        {{ __('menu.properties') }}
    @endsection


    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">

        <div class="card mt-10">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <h2 class="fw-bold mb-0">{{ __('menu.properties_map') }}</h2>
                </div>
            </div>

            <div class="card-body pt-0">
                <div id="map" style="height: 500px; width: 100%; border-radius: 10px;"></div>
            </div>
        </div>

        {{-- Leaflet CSS/JS --}}
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const map = L.map('map').setView([31.5, 34.4667], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                // 🔹 أيقونة البيت الجديدة
                const houseIcon = L.icon({
                    iconUrl: '/assets/media/icons/home.png', // مسار الصورة
                    iconSize: [40, 40], // حجم الايقونة
                    iconAnchor: [20, 40], // النقطة اللي بتمركز منها
                    popupAnchor: [0, -35] // مكان البوب أب بالنسبة للأيقونة
                });

                const properties = @json($properties);

                // 🔹 أضف العقارات على الخريطة بأيقونة البيت
                properties.forEach(property => {
                    if (property.latitude && property.longitude) {
                        const marker = L.marker([property.latitude, property.longitude], { icon: houseIcon }).addTo(map);

                        marker.bindPopup(`
                <strong>${property.property_owner}</strong><br>
                ${property.address}<br>
                <span class="badge bg-primary text-white">${property.ownership_type}</span>
            `);
                    }
                });

                // 🔹 موقع المستخدم الحالي
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(pos => {
                        const { latitude, longitude } = pos.coords;
                        const userMarker = L.marker([latitude, longitude]).addTo(map);
                        userMarker.bindPopup('📍 Your current location').openPopup();
                        map.setView([latitude, longitude], 14);
                    });
                }
            });

        </script>

        {{-- سكربت الخريطة --}}

    </div>
    <!--end::Content container-->



</x-default-layout>
