<div class="modal fade" id="add_currency_modal">
    <div class="modal-dialog">
        <form action="{{ route('note_book.create') }}" method="post" enctype="multipart/form-data">
            @csrf
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
                                <label for="">عنوان الملاحظة</label>
                                <input name="note_text" class="form-control" type="text"
                                       placeholder="عنوان الملاحظة" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">وصف الملاحظة</label>
                                <textarea required class="form-control" name="note_description" id="" cols="30" rows="3" placeholder="وصف الملاحظة"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn btn-success">حفظ</button>
                </div>

            </div>
        </form>

    </div>
</div>
