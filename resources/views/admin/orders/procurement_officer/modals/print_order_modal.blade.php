<div class="modal fade" id="PrintOrderPdfModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form target="_blank" action="{{ route('orders.procurement_officer.print_order_pdf') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="supplier_id_input">
                <input type="hidden" id="reference_number_input">
                <input type="hidden" id="from_input">
                <input type="hidden" id="to_input">
                <input type="hidden" id="to_user_input">
                <input type="hidden" id="user_category_input">
                <div class="modal-header">
                    <h4 class="modal-title">طباعة طلبيات</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">نوع الطباعة</label>
                                    <select class="form-control" name="print_type" id="">
                                        <option value="with_filter">طباعة كاملة</option>
                                        <option value="without_filter">طباعة جزئية</option>
                                    </select>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-success">طباعة</button>
                </div>
            </form>
        </div>

    </div>

</div>
