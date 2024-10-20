@extends('home')
@section('title')
    تقييم الطلب
@endsection
@section('header_title')
    تقييم الطلب
@endsection
@section('header_link')
    الرئيسية
@endsection
@section('header_title_link')
    تقييم الطلبات
@endsection
@section('style')
    <style>
        .remove-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background: red;
            color: white;
            cursor: pointer;
            padding: 2px 5px;
            border-radius: 50%;
            font-size: 14px;
            line-height: 1;
        }
    </style>
@endsection
@section('content')
    @if ($data->isEmpty())
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('evaluation.create_evaluation') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $order->id }}" name="order_id">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <div>
                                            <h4>الرقم المرجعي للطلبية : <span>{{ $order->reference_number }}</span></h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th>اسم المعيار</th>
                                                <th>1</th>
                                                <th>2</th>
                                                <th>3</th>
                                                <th>4</th>
                                                <th>5</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($criteria as $key)
                                                <tr>
                                                    <td>{{ $key->name }}</td>
                                                    <td><input required type="radio" name="criteria[{{ $key->id }}]"
                                                            value="1">
                                                    </td>
                                                    <td><input required type="radio" name="criteria[{{ $key->id }}]"
                                                            value="2">
                                                    </td>
                                                    <td><input required type="radio" name="criteria[{{ $key->id }}]"
                                                            value="3">
                                                    </td>
                                                    <td><input required type="radio" name="criteria[{{ $key->id }}]"
                                                            value="4">
                                                    </td>
                                                    <td><input required type="radio" name="criteria[{{ $key->id }}]"
                                                            value="5">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">الملفات</label>
                                        <div id="imageFields" class="mb-2">
                                            <div class="image-upload">
                                                <input type="file" name="imageInput" name="files[]" class="image-input"
                                                    accept="image/*,.pdf,.doc,.docx,.xls,.xlsx" multiple>
                                            </div>
                                        </div>
                                        <div id="imagePreviewContainer" class="mt-2"
                                            style="display: flex; flex-wrap: wrap; gap: 10px;">
                                        </div>
                                        @if (!empty($evaluation->file))
                                            <a type="text"
                                                href="{{ asset('storage/evaluation_file/' . $evaluation->file) }}"
                                                download="{{ $key->attachment }}" class="btn btn-primary btn-sm"><span
                                                    class="fa fa-download"></span></a>
                                            <button
                                                onclick="viewAttachment({{ $key->id }},'{{ asset('storage/evaluation_file/' . $evaluation->file) }}',null)"
                                                href="" class="btn btn-success btn-sm" data-toggle="modal"
                                                data-target="#modal-lg-view_attachment" type="button"><span
                                                    class="fa fa-search"></span></button>
                                        @endif
                                        {{-- <input type="file" name="file" class="form-control"> --}}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">ملاحظات</label>
                                        <textarea name="notes" class="form-control" id="" cols="30" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success">حفظ التقييم</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        @if (auth()->user()->user_role == 1)
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('evaluation.evaluation_order_pdf', ['id' => $order->id]) }}"
                                class="btn btn-warning btn-sm"><span class="fa fa-print"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @foreach ($data as $evaluation)
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('evaluation.create_evaluation') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{ $order->id }}" name="order_id">
                                <input type="hidden" value="{{ $evaluation->id }}" name="evaluation_id">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h4>تقييم بواسطة <span>{{ $evaluation->user->role->name }}</span> :
                                                            <span>{{ $evaluation->user->name }}</span>
                                                        </h4>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="float-right">
                                                            <span
                                                                class="badge badge-success">{{ round(($evaluation->evaluation_value * 100) / $evaluation->criteria_sum_mark, 2) }}
                                                                / 100</span>
                                                        </h6>
                                                    </div>
                                                </div>

                                                @if (auth()->user()->user_role == 1)
                                                    <div class="form-group">
                                                        <div
                                                            class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                            <input
                                                                onchange="update_evaluation_status_ajax({{ $evaluation->id }} , this.checked ? 'rated' : 'not_rated' )"
                                                                type="checkbox"
                                                                @if ($evaluation->status == 'rated') checked @endif
                                                                class="custom-control-input"
                                                                id="customSwitch{{ $evaluation->id }}">
                                                            <label class="custom-control-label"
                                                                for="customSwitch{{ $evaluation->id }}">حالة
                                                                التقييم</label>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <table class="table text-center">
                                            <thead>
                                                <tr>
                                                    <th>اسم المعيار</th>
                                                    <th>1</th>
                                                    <th>2</th>
                                                    <th>3</th>
                                                    <th>4</th>
                                                    <th>5</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($evaluation->evaluation_criteria as $key)
                                                    <tr>
                                                        <td>{{ $key->criteria->name }}</td>
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <td>
                                                                <input @if (
                                                                    $evaluation->status == 'rated' ||
                                                                        (auth()->user()->role_id == 2 || auth()->user()->role_id == 9 || auth()->user()->role_id == 10)) disabled @endif
                                                                    required type="radio"
                                                                    name="criteria[{{ $key->criteria->id }}]"
                                                                    @if ($key->value == $i) checked @endif
                                                                    value="{{ $i }}"
                                                                    id="criteria{{ $key->criteria->id }}_{{ $i }}">
                                                            </td>
                                                        @endfor
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">الملفات</label>
                                            <div id="imageFields">
                                                <div class="image-upload">
                                                    <input @if (
                                                        $evaluation->status == 'rated' ||
                                                            (auth()->user()->role_id == 2 || auth()->user()->role_id == 9 || auth()->user()->role_id == 10)) disabled @endif type="file"
                                                        id="imageInput{{ $evaluation->id }}" name="files[]"
                                                        class="image-input" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx"
                                                        multiple>
                                                </div>
                                            </div>
                                            <div id="imagePreviewContainer{{ $evaluation->id }}"
                                                style="display: flex; flex-wrap: wrap; gap: 10px;" class="mt-2"></div>

                                            @foreach ($evaluation->files as $file)
                                                <div class="file-box p-2"
                                                    style="display: inline-block; position: relative; text-align: center;">
                                                    <!-- التحقق مما إذا كان الملف صورة -->
                                                    @if (in_array(pathinfo($file->attachment, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                        <img src="{{ asset('storage/evaluation_file/' . $file->attachment) }}"
                                                            alt="Image"
                                                            style="width: 100px; height: 100px; object-fit: cover; margin-bottom: 5px;">
                                                    @else
                                                        <!-- إذا كان ملف غير صورة، عرض أيقونة الملف -->
                                                        <a href="{{ asset('storage/evaluation_file/' . $file->attachment) }}"
                                                            target="_blank" download>
                                                            <i class="fa fa-file"
                                                                style="font-size: 100%; color: #000; margin-bottom: 5px;width: 100px; height: 100px;">
                                                                <span
                                                                    style="font-size: 15px">{{ $file->attachment }}</span>
                                                            </i>
                                                        </a>
                                                    @endif
                                                    <button @if (
                                                        $evaluation->status == 'rated' ||
                                                            (auth()->user()->role_id == 2 || auth()->user()->role_id == 9 || auth()->user()->role_id == 10)) disabled @endif
                                                        type="button" class="btn btn-sm btn-danger"
                                                        style="position: absolute; top: 0; right: 0;"
                                                        onclick="deleteImage({{ $file->id }})">X</button>
                                                </div>
                                            @endforeach



                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <div class="form-group">
                                            <label for="">ملاحظات</label>
                                            <textarea @if (
                                                $evaluation->status == 'rated' ||
                                                    (auth()->user()->role_id == 2 || auth()->user()->role_id == 9 || auth()->user()->role_id == 10)) disabled @endif
                                                onchange="update_notes_ajax({{ $evaluation->id }} , this.value)" name="notes" class="form-control"
                                                id="notes{{ $evaluation->id }}" cols="30" rows="3">{{ $evaluation->notes }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button @if (
                                            $evaluation->status == 'rated' ||
                                                (auth()->user()->role_id == 2 || auth()->user()->role_id == 9 || auth()->user()->role_id == 10)) disabled @endif type="submit"
                                            class="btn btn-success">حفظ التقييم</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            orders_list();
        });

        // عرض معاينة الصور المرفوعة
        $(document).ready(function() {
            $('[id^="imageInput"]').on('change', function() {
                var evaluationId = $(this).attr('id').replace('imageInput', '');
                var files = this.files;
                var previewContainer = $('#imagePreviewContainer' + evaluationId);

                if (files) {
                    // Limit to 5 files
                    if (previewContainer.find('.file-box').length + files.length > 5) {
                        alert('You can only upload a maximum of 5 files.');
                        return;
                    }

                    $.each(files, function(index, file) {
                        // Check file size (5MB limit)
                        if (file.size > 5 * 1024 * 1024) {
                            alert(`File ${file.name} exceeds the 5MB size limit.`);
                            return;
                        }

                        // Check if the file is an image
                        if (file.type.startsWith('image/')) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                var imageBox = `
                            <div class="file-box">
                                <span class="remove-file btn btn-danger btn-sm">X</span>
                                <img src="${e.target.result}" alt="Uploaded Image" class="m-2" style="width:100px; height:100px; object-fit:cover;">
                            </div>
                        `;
                                previewContainer.append(imageBox);
                            };
                            reader.readAsDataURL(file);
                        } else {
                            // For non-image files
                            var fileBox = `
                        <div class="file-box">
                            <span class="remove-file btn btn-danger btn-sm">X</span>
                            <a href="${URL.createObjectURL(file)}" download="${file.name}" style="display: block; text-align: center; margin-top: 10px;">${file.name}</a>
                        </div>
                    `;
                            previewContainer.append(fileBox);
                        }
                    });
                }
            });

            // Remove image or file with confirmation
            $(document).on('click', '.remove-file', function() {
                if (confirm('Are you sure you want to remove this file?')) {
                    $(this).parent().remove(); // Remove the parent element
                }
            });
        });


        function orders_list() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('evaluation.orders_list') }}',
                method: 'post',
                headers: headers,
                data: {

                },
                success: function(data) {
                    $('#orders_list_table').html(data)
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }

            });
        }

        function update_evaluation_status_ajax(id, status) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('evaluation.update_evaluation_status_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                    'status': status
                },
                success: function(data) {
                    $('#orders_list_table').html(data)
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }

            });
        }

        function deleteImage(imageId) {
            if (confirm('هل أنت متأكد من حذف هذه الصورة؟')) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var headers = {
                    "X-CSRF-Token": csrfToken
                };
                $.ajax({
                    url: '{{ route('evaluation.delete_image') }}',
                    method: 'post',
                    headers: headers,
                    data: {
                        'id': imageId,
                    },
                    success: function(data) {
                        location
                            .reload(); // يمكنك تحسين هذه الخطوة بتحديث المحتوى فقط دون إعادة تحميل الصفحة بالكامل

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }

                });

            }
        }

        function update_notes_ajax(id, value) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                "X-CSRF-Token": csrfToken
            };
            $.ajax({
                url: '{{ route('evaluation.update_notes_ajax') }}',
                method: 'post',
                headers: headers,
                data: {
                    'id': id,
                    'notes': value
                },
                success: function(data) {
                    $('#orders_list_table').html(data)
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }

            });
        }
    </script>
@endsection
