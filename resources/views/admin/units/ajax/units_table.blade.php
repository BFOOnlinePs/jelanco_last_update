<div class="row mb-2">
    <div class="col-12">
        <span class="text-muted">عدد النتائج: {{ $data->total() }}</span>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>الاسم</th>
            <th>الاسم باللغة الانجليزية</th>
        </tr>
        </thead>
        <tbody>
        @forelse($data as $key)
            <tr>
                <td>
                    <input type="text" class="form-control" onchange="updateUnitName({{ $key->id }})" id="unit_name_{{ $key->id }}" value="{{ $key->unit_name }}">
                </td>
                <td>
                    <input type="text" class="form-control" onchange="updateUnitName({{ $key->id }})" id="unit_name_en_{{ $key->id }}" value="{{ $key->unit_name_en }}">
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="2" class="text-center">لا توجد وحدات مطابقة</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

@if($data->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $data->links() }}
    </div>
@endif
