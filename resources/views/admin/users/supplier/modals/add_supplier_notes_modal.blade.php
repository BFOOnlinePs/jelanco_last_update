<div class="modal fade" id="add_supplier_notes_modal">
    <div class="modal-dialog modal-xl">
        <form action="{{ route('users.supplier.supplier_notes.create_supplier_notes') }}"
              method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="supplier_id"
                   value="{{ $data->id }}">
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
                                <textarea name="text" class="form-control" id="" cols="30"
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
