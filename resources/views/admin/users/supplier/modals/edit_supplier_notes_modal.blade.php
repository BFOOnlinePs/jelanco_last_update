<div class="modal fade" id="edit_supplier_notes_modal">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('users.supplier.supplier_notes.update_supplier_notes') }}"
              method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="supplier_id"
                   value="{{ $data->id }}">
            <input type="hidden" name="id" id="supplier_notes_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة ملاحظة للمورد</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">النص</label>
                                <textarea name="text" class="form-control" id="supplier_notes_text" cols="30"
                                          rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">الملف</label>
                                <div class="custom-file">
                                    <input name="file" type="file"
                                           class="custom-file-input"
                                           id="customFile">
                                    <label class="custom-file-label"
                                           for="customFile">تحميل الملف</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger"
                            data-dismiss="modal">اغلاق
                    </button>
                    <button type="submit" class="btn btn-dark">حفظ
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
