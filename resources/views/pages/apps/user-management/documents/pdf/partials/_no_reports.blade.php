<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>#</th>
        <th>صاحب العقار</th>
        <th>العنوان</th>
        <th>نوع الملكية</th>
        <th>عدد الطوابق</th>
        <th>عدد السكان</th>
        <th>الموقع</th>
    </tr>
    </thead>
    <tbody>
    @foreach($properties as $property)
        <tr>
            <td>{{ $property->id }}</td>
            <td>{{ $property->user->name ?? 'غير معروف' }}</td>
            <td>{{ $property->address ?? 'غير متوفر' }}</td>
            <td>
                {{ $property->ownership_type === 'owned' ? 'مملوك' : 'مستأجر' }}
            </td>
            <td>{{ $property->floors_count ?? '-' }}</td>
            <td>{{ $property->residents_count }}</td>

            <td>
                @if($property->latitude && $property->longitude)
                    <a target="_blank"
                       href="https://www.google.com/maps?q={{ $property->latitude }},{{ $property->longitude }}">
                        عرض الخريطة
                    </a>
                @else
                    غير متوفر
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
