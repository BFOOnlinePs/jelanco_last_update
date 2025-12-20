<div class="modal fade" id="AddNewDate">
    <div class="modal-dialog">
        <div class="modal-content">
            {{-- أضفنا id="ajaxDateForm" --}}
            <form id="ajaxDateForm" action="{{ route('orders.update_order_production_date') }}" method="post">
                @csrf
                <input type="hidden" name="order_id" id="modal_order_id">
                <div class="modal-header">
                    <h4 class="modal-title">تحديث تاريخ الإنتاج</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>التاريخ الجديد</label>
                        <input type="date" class="form-control" name="expected_arrival_date" id="new_date" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>