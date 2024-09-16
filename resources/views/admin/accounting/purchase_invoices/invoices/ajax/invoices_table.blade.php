<div class="row">
  <table class="table table-bordered search_table table-hover table-sm">
    <thead>
        <tr>
            <th style="width: 250px">الصنف</th>
            <th>الكمية</th>
            <th>السعر</th>
            <th>خصم</th>
            <th>بونص</th>
            <th>المجموع</th>
        </tr>
    </thead>
    <tbody>
        @if($data->isEmpty())
            <tr>
                <td class="text-center" colspan="6">لا توجد بيانات</td>
            </tr>
        @else
        @foreach ($data as $key)
        <tr id="item_row_{{ $key->id }}">
            <td>
                @if(!empty($key['product']->product_photo))
                    <img width="50" src="{{ asset('storage/product/'.$key["product"]->product_photo??'') }}" alt="">
                @else
                    <img width="50" src="{{ asset('img/no_img.jpeg') }}" alt="">
                @endif
            </td>
            <td>{{ $key['product']->product_name_ar??'' }}</td>
            <td>
                <input class="input" id="qty_input_{{ $key->id }}" onchange="edit_inputs_from_invoice({{ $key->id }},this.value,'qty')" type="text" value="{{ $key->quantity ?? '' }}">
            </td>
            <td>
                <input class="input" id="rate_input_{{ $key->id }}" onchange="edit_inputs_from_invoice({{ $key->id }},this.value,'rate')" type="text" value="{{ $key->rate ?? '' }}">
            </td>
            <td>
                <input class="input" style="width: 40px" onchange="edit_inputs_from_invoice({{ $key->id }}, this.value, 'discount')" type="text" value="{{ $key->discount ?? '' }}"> %
            </td>
            <td>
                <input class="input" onchange="edit_inputs_from_invoice({{ $key->id }}, this.value, 'bonus')" type="text" value="{{ $key->bonus ?? '' }}">
            </td>
            <td id="total_td_{{ $key->id }}"></td>
            <td>
                <button onclick="delete_item({{ $key->id }})" class="btn btn-danger btn-sm"><span class="fa fa-close"></span></button>
            </td>
        </tr>
        @endforeach

        @endif
    </tbody>
    </table>
</div>
<div class="row">
    <div class="col-md-7">

    </div>
    <div class="col-md-5">
        <table style="width: 100%" class="table-sm table-bordered rounded">
            <tr>
                <td class="bg-dark" colspan="1">المجموع الكلي</td>
                <td class="text-center" id="sub_total"></td>
            </tr>
            <tr>
                <td class="bg-dark" colspan="1">الخصم</td>
                <td class="text-center">0</td>
            </tr>
            <tr>
                <td class="bg-dark" colspan="1">{{ $invoice->tax->tax_name??'' }} ({{ $invoice->tax->tax_ratio??'' }})%</td>
                <td class="text-center" id="tax_id"></td>
                <td>
                    <button type="button" class="btn btn-info btn-sm rounded-circle" data-toggle="modal" data-target="#discount-modal">
                        <span class="fa fa-edit"></span>
                    </button>
                </td>
            </tr>
            <tr>
                <td class="bg-dark" colspan="1">الرصيد المستحق</td>
                <td class="text-center" id="sub_total_after_tax"></td>
            </tr>
        </table>
    </div>
</div>
        <script>
            var sub_total = 0;
            var tax = 0;
            var sub_total_after_tax = 0;
            @foreach($data as $key)
                sub_total += updateTotal({{ $key->id }});
            @endforeach
            tax = ((sub_total * {{ $invoice->tax->tax_ratio??0 }}) / 100);
            if(document.getElementById('tax_type').value == 'before'){
                sub_total_after_tax = sub_total ;
            }
            else if(document.getElementById('tax_type').value == 'after'){
                sub_total_after_tax = sub_total + ((sub_total * {{ $invoice->tax->tax_ratio??0 }}) / 100);
            }
            document.getElementById('sub_total').innerText = sub_total;
            document.getElementById('tax_id').innerText = tax;
            document.getElementById('sub_total_after_tax').innerText = sub_total_after_tax.toFixed(2);


            function updateSubTotal() {
                var sub_total = 0;
                var tax = 0;
                var sub_total_after_tax = 0;
                @foreach($data as $key)
                    sub_total += updateTotal({{ $key->id }});
                @endforeach
                tax = ((sub_total * {{ $invoice->tax->tax_ratio??0 }}) / 100);
                if(document.getElementById('tax_type').value == 'before'){
                    sub_total_after_tax = sub_total ;
                }
                else if(document.getElementById('tax_type').value == 'after'){
                    sub_total_after_tax = sub_total + ((sub_total * {{ $invoice->tax->tax_ratio??0 }}) / 100);
                }
                document.getElementById('sub_total').innerText = sub_total;
                document.getElementById('tax_id').innerText = tax;
                document.getElementById('sub_total_after_tax').innerText = sub_total_after_tax;
                return sub_total;
            }
            function updateTotal(itemId) {
            var qty = parseFloat(document.getElementById('qty_input_' + itemId).value) || 0;
            var rate = parseFloat(document.getElementById('rate_input_' + itemId).value) || 0;
            var total = qty * rate;
            document.getElementById('total_td_' + itemId).innerText = total;
            return total;
        }

        $(".input").keypress(function(event) {
            var regex = /^[0-9\s]+$/;
            var inputChar = String.fromCharCode(event.which);

            if (regex.test(inputChar)) {
                return true;
            }

            return false;
        });

            function update_tax_type(){
                update_tax_id_ratio();
                document.getElementById('tax_type').value;
                updateSubTotal();
                $('#discount-modal').modal('hide');
                invoices_table();
            }
        </script>
