<div class="d-flex align-items-center mb-3">
    <img width="60" height="60" class="rounded-circle border mr-3" style="object-fit: cover"
         src="{{ asset('storage/user_photo/'.($data->user_photo ?: 'avatar.png')) }}" alt="">
    <div>
        <h5 class="mb-1">{{ $data->name }}</h5>
        @if($data->potential_suppliers == 'certified')
            <span class="badge badge-success">مورد معتمد</span>
        @else
            <span class="badge badge-secondary">مورد غير معتمد</span>
        @endif
        @if($data->status == 1)
            <span class="badge badge-info">فعال</span>
        @else
            <span class="badge badge-danger">غير فعال</span>
        @endif
    </div>
</div>

<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#sdm-general" role="tab">المعلومات العامة</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sdm-contacts" role="tab">جهات الاتصال ({{ $company_contact_person->count() }})</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sdm-banks" role="tab">معلومات البنك ({{ $supplier_banks->count() }})</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sdm-products" role="tab">الأصناف ({{ $products->count() }})</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sdm-notes" role="tab">ملاحظات المورد ({{ $supplier_notes->count() }})</a></li>
</ul>

<div class="tab-content border border-top-0 p-3" style="max-height: 60vh; overflow-y: auto">
    <div class="tab-pane fade show active" id="sdm-general" role="tabpanel">
        <table class="table table-sm table-bordered mb-0">
            <tbody>
            <tr><th style="width: 30%">الاسم</th><td>{{ $data->name }}</td></tr>
            <tr><th>الايميل</th><td>{{ $data->email }}</td></tr>
            <tr><th>رقم الهاتف الاول</th><td>{{ $data->user_phone1 }}</td></tr>
            <tr><th>رقم الهاتف الثاني</th><td>{{ $data->user_phone2 ?: 'لا يوجد' }}</td></tr>
            <tr><th>مجال العمل</th><td>{{ $user_categories->isEmpty() ? 'لا يوجد' : $user_categories->implode('، ') }}</td></tr>
            <tr>
                <th>الموقع الالكتروني</th>
                <td>
                    @if($data->user_website)
                        <a href="{{ \Illuminate\Support\Str::startsWith($data->user_website, ['http://', 'https://']) ? $data->user_website : 'http://'.$data->user_website }}" target="_blank">{{ $data->user_website }}</a>
                    @else
                        لا يوجد
                    @endif
                </td>
            </tr>
            <tr><th>العنوان</th><td style="white-space: pre-wrap">{{ $data->user_address }}</td></tr>
            <tr><th>ملاحظات</th><td style="white-space: pre-wrap">{{ $data->user_notes }}</td></tr>
            </tbody>
        </table>
    </div>

    <div class="tab-pane fade" id="sdm-contacts" role="tabpanel">
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-hover mb-0">
                <thead>
                <tr>
                    <th>الاسم</th>
                    <th>الهاتف</th>
                    <th>الايميل</th>
                    <th>الوتس اب</th>
                    <th>الوي شات</th>
                    <th>العنوان</th>
                </tr>
                </thead>
                <tbody>
                @forelse($company_contact_person as $key)
                    <tr>
                        <td>{{ $key->contact_name }}</td>
                        <td>{{ $key->mobile_number }}</td>
                        <td>{{ $key->email }}</td>
                        <td>{{ $key->whats_app_number }}</td>
                        <td>{{ $key->wechat_number }}</td>
                        <td>{{ $key->address }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">لا توجد جهات اتصال</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-pane fade" id="sdm-banks" role="tabpanel">
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-hover mb-0">
                <thead>
                <tr>
                    <th>اسم المستفيد</th>
                    <th>رقم حساب البنك</th>
                    <th>اسم البنك</th>
                    <th>عنوان البنك</th>
                    <th>swift code</th>
                    <th>iban number</th>
                </tr>
                </thead>
                <tbody>
                @forelse($supplier_banks as $key)
                    <tr>
                        <td>{{ $key->beneficiary_name }}</td>
                        <td>{{ $key->account_number }}</td>
                        <td>{{ $key->user_bank_name }}</td>
                        <td>{{ $key->user_bank_address }}</td>
                        <td>{{ $key->user_swift_code }}</td>
                        <td>{{ $key->user_iban_number }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">لا توجد معلومات بنك</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-pane fade" id="sdm-products" role="tabpanel">
        <table class="table table-sm table-bordered table-hover mb-0">
            <thead>
            <tr>
                <th>#</th>
                <th>الباركود</th>
                <th>اسم الصنف</th>
                <th>الصنف باللغة الانجليزية</th>
            </tr>
            </thead>
            <tbody>
            @forelse($products as $key)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $key->barcode }}</td>
                    <td>{{ $key->product_name_ar }}</td>
                    <td>{{ $key->product_name_en }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">لا توجد اصناف</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="tab-pane fade" id="sdm-notes" role="tabpanel">
        <table class="table table-sm table-bordered table-hover mb-0">
            <thead>
            <tr>
                <th>الملاحظة</th>
                <th>المرفق</th>
            </tr>
            </thead>
            <tbody>
            @forelse($supplier_notes as $key)
                <tr>
                    <td style="white-space: pre-wrap">{{ $key->text }}</td>
                    <td>
                        @if(empty($key->file))
                            لا يوجد ملفات
                        @else
                            <a href="{{ asset('storage/supplier_notes/'.$key->file) }}" download="{{ $key->file }}"
                               class="btn btn-primary btn-sm"><span class="fa fa-download"></span></a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="2" class="text-center">لا توجد ملاحظات</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="text-left mt-3">
    <a href="{{ route('users.supplier.details', ['id' => $data->id]) }}" target="_blank" class="btn btn-info btn-sm">
        <span class="fa fa-external-link-alt"></span> فتح صفحة المورد كاملة
    </a>
</div>
