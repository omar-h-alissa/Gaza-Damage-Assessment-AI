<table class="table">
    <thead>
    <tr>
        <th>التاريخ</th>
        <th>العدد الكلي للبلاغات</th>
    </tr>
    </thead>
    <tbody>
    {{-- المتغير $timeline هنا هو $report_data الممرر من generatePdf --}}
    @foreach($timeline as $item)
        <tr>
            {{-- يتم عرض حقل 'date' و 'total' كما تم تعريفهما في دالة timelinePdf() --}}
            <td>{{ $item->date }}</td>
            <td>{{ $item->total }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
