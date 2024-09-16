<div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" id="select_tag_fro_order_modal">
    <div class="modal-dialog modal-lg">
        <input type="hidden" id="chat_message_id" name="order_id">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-dark">عمل اشارة للطلبية</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <input onkeyup="list_orders_for_tag()" id="order_search_for_tag" type="text" class="form-control" placeholder="بحث عن طلبية">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div id="orders_table_for_tag">

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
