<div class="modal fade" id="product_notes_modal">
    <div class="modal-dialog modal-dialog-centered">
        <form style="width: 100%" action="{{ route('product.create_product_notes') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" value="{{ $data->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة ملاحظة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">اضافة ملاحظة</label>
                                <input required type="text" name="notes" placeholder="اضافة ملاحظة" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-dark">حفظ</button>
                </div>

            </div>
        </form>

    </div>
</div>
