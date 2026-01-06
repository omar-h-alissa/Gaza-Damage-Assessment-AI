<x-default-layout>

    @section('title')
        {{ __('menu.reports') }}
    @endsection


    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">

        <div class="card mt-10">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <h2 class="fw-bold mb-0"> {{ __('menu.reports_map') }}</h2>
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
            // بيانات العقارات من PHP
            const properties = @json($properties);

            // تهيئة الخريطة
            const map = L.map('map').setView([31.5, 34.5], 12); // تكبير للتركيز على المنطقة

            // إضافة خريطة OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // دالة لتحديد لون المربع حسب نسبة الضرر
            function getColor(damage_percentage) {
                if (damage_percentage < 30) return 'green';       // قليل الضرر
                if (damage_percentage < 70) return 'orange';      // متوسط
                return 'red';                                     // عالي
            }

            // إضافة العقارات كـ مربعات على الخريطة
            properties.forEach(prop => {
                const lat = parseFloat(prop.lat);   // تحويل النص إلى رقم
                const lng = parseFloat(prop.lng);

                if (!lat || !lng) return; // تجاهل إذا الإحداثيات غير صحيحة

                const color = getColor(prop.damage_percentage);

                // مربع أكبر قليلاً ليكون واضحاً
                const halfSize = 0.0005; // نصف حجم المربع (يمكن تعديل حسب التكبير/التصغير)

                const bounds = [
                    [lat - halfSize, lng - halfSize],
                    [lat + halfSize, lng + halfSize]
                ];

                const rect = L.rectangle(bounds, { color: color, weight: 1, fillOpacity: 0.6 }).addTo(map);

                // Popup عند الضغط على المربع
                rect.bindPopup(`
        <b>Property ID:</b> ${prop.id}<br>
        <b>Damage %:</b> ${prop.damage_percentage}%<br>
        <b>Damage State:</b> ${prop.damage_state}
    `);
            });

        </script>


        {{-- سكربت الخريطة --}}

    </div>
    <!--end::Content container-->



</x-default-layout>
