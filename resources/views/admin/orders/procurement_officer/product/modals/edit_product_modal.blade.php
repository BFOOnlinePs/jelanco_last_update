<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="edit_product_modal">
    <div class="modal-dialog modal-lg">
            <input type="hidden" id="product_id">
            <input type="hidden" id="order_id" value="{{ $order->id }}" name="order_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-dark">تعديل بيانات المنتج</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">اسم المنتج عربي</label>
                                        <input type="text" id="product_name_arabic" class="form-control" placeholder="اسم المنتج عربي">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">اسم المنتج انجليزي</label>
                                        <input type="text" id="product_name_english" class="form-control" placeholder="اسم المنتج انجليزي">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">تصنيف المنتج</label>
                                        <select class="form-control select2bs4" name="" id="product_category_id">
                                            <option value="">اختر تصنيف للمنتج</option>
                                            @foreach($category as $key)
                                                <option value="{{ $key->id }}">{{ $key->cat_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">الوحدة</label>
                                        <select class="form-control select2bs4" name="" id="product_unit_id">
                                            <option value="">اختر وحدة</option>
                                            @foreach($unit as $key)
                                                <option value="{{ $key->id }}">{{ $key->unit_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">باركود الصنف</label>
                                        <input type="text" id="product_barcode" class="form-control" placeholder="باركود الصنف">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 pt-2 text-center">
                            <div class="form-group text-center">
                                    <img id="image_preview_container" width="150" alt="">
                            </div>
                            <div>
                                <hr>
                                <form method="POST" enctype="multipart/form-data" id="upload_image_form">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input class="form-control" type="file" name="image" placeholder="Choose image" id="image">
                                                <span class="text-danger">{{ $errors->first('title') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">رفع الصورة</button>
                                        </div>
                                    </div>
                                </form>
                                {{--                                            <p>يحتوي هذا القسم على المعلومات الأساسية للموظف</p>--}}
                                {{--                                            <a href="{{ route('users.employees.edit',['id'=>$data->id]) }}" class="btn btn-info">تعديل بيانات الموظف</a>--}}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
                    <button type="button" onclick="update_product_from_ajax()" class="btn btn-dark">حفظ البيانات</button>
                </div>
            </div>
    </div>
</div>
