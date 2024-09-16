<div class="modal fade" id="product_table_from_price_offer_modal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('procurement_officer.orders.price_offer.create_price_offer') }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="modal-title text-center">ارشيف طلب هذا الصنف <br>
                            <span id="product_price_offer_name" class="font-weight-bold"></span>
                            </h4>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="table-responsive" id="product_table_price_offer">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">اغلاق</button>
{{--                    <button type="submit" class="btn btn-primary">حفظ</button>--}}
                </div>
            </form>
        </div>
    </div>
</div>
