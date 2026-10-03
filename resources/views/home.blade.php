<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="theme-color" content="#0f1b3d">

    <title>{{ trim($__env->yieldContent('title')) ?: 'الرئيسية' }} | {{ company_name }}</title>
    <link rel="icon" href="{{ App\Models\SystemSettingModel::logoUrl() }}">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap_rtl-v4.2.1/bootstrap.min.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/mycustomstyle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/jquery-ui/jquery-ui.css') }}">
    @yield('style')
    @include('layouts.theme')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<a class="jl-skip-link" href="#main-content">تخطي إلى المحتوى</a>
<div class="wrapper">
    @include('layouts.navbar')

    @include('layouts.sidebar')

    @include('layouts.content')

    {{-- عارض المرفقات العام (يستخدمه viewAttachment من كل الصفحات) --}}
    <div class="modal fade" id="modal-lg-view_attachment" tabindex="-1" role="dialog" aria-labelledby="view-attachment-title" aria-hidden="true">
        <input type="hidden" id="viewAttachmentWithId">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="view-attachment-title"><i class="fa fa-paperclip text-muted jl-i" aria-hidden="true"></i>عرض المرفق</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe id="view_attachment_result" class="jl-attachment-frame" src="" title="معاينة المرفق"></iframe>
                    <div style="display: none" id="note_form" class="mt-3">
                        <label for="note_input">ملاحظات المرفق <small class="text-muted font-weight-normal">(تُحفظ تلقائياً عند الخروج من الحقل)</small></label>
                        <textarea class="form-control" id="note_input" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-light" data-dismiss="modal">إغلاق</button>
                    <a id="download-attachment" class="btn btn-primary" href="#">
                        <i class="fa fa-download" aria-hidden="true"></i> تحميل
                    </a>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>

<script src="{{ asset('assets/jquery-ui/jquery-ui.js') }}"></script>

@include('layouts.ajax_search')

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    $(function() {
        // Select all input elements with type="date" and apply Datepicker
        $('.date_format').datepicker({
            dateFormat: 'yy-mm-dd',
            isRTL: true
        });
    });
</script>

@yield('script')

<script>
    // معاينة مكبرة لصور الأصناف عند المرور على .jl-thumb[data-preview]
    // المعاينة fixed على مستوى الصفحة حتى لا يقصها table-responsive أو المودال
    (function ($) {
        var $preview = null;

        function getPreview() {
            if (!$preview) {
                $preview = $('<figure class="jl-thumb-preview" aria-hidden="true"><img alt=""><figcaption></figcaption></figure>')
                    .appendTo('body');
            }
            return $preview;
        }

        // تظهر على يسار الصورة المصغرة، وتنقلب لليمين إذا لم يكن هناك مكان، وتبقى داخل الشاشة دائماً
        function place(thumb) {
            var rect = thumb.getBoundingClientRect();
            var el = getPreview()[0];
            var gap = 14, pad = 8;
            var w = el.offsetWidth, h = el.offsetHeight;

            var left = rect.left - gap - w;
            if (left < pad) {
                left = rect.right + gap;
            }
            left = Math.min(Math.max(pad, left), window.innerWidth - pad - w);

            var top = rect.top + rect.height / 2 - h / 2;
            top = Math.min(Math.max(pad, top), window.innerHeight - pad - h);

            el.style.left = left + 'px';
            el.style.top = top + 'px';
        }

        function hide() {
            if ($preview) {
                $preview.removeClass('is-visible');
            }
        }

        $(document)
            .on('mouseenter focusin', '.jl-thumb[data-preview]', function () {
                var $p = getPreview();
                var caption = $(this).data('caption') || '';
                $p.find('img').attr('src', $(this).data('preview'));
                $p.find('figcaption').text(caption).toggle(caption !== '');
                place(this);
                $p.addClass('is-visible');
            })
            .on('mouseleave focusout', '.jl-thumb[data-preview]', hide);

        window.addEventListener('scroll', hide, true);
        $(window).on('resize', hide);
    })(jQuery);
</script>

<script>
    // بحث select2 بالكلمات: كل كلمة لازم تكون موجودة بأي مكان بالنص وبأي ترتيب
    // مثال: "سيريه كبير" تجيب "سيريه رش ابجل كبير - ذهبي"
    function select2WordsMatcher(params, data) {
        var term = String(params.term || '').trim().toLowerCase();
        if (term === '') {
            return data;
        }
        if (data.children && data.children.length > 0) {
            var match = $.extend(true, {}, data);
            for (var c = data.children.length - 1; c >= 0; c--) {
                if (select2WordsMatcher(params, data.children[c]) == null) {
                    match.children.splice(c, 1);
                }
            }
            if (match.children.length > 0) {
                return match;
            }
        }
        var text = String(data.text || '').toLowerCase();
        var words = term.split(/\s+/);
        for (var i = 0; i < words.length; i++) {
            if (text.indexOf(words[i]) === -1) {
                return null;
            }
        }
        return data;
    }

    if ($.fn.select2) {
        // القوائم اللي بتتهيأ بعد هذا السطر (داخل document.ready او بعد ajax)
        $.fn.select2.defaults.set('matcher', select2WordsMatcher);
        // القوائم اللي تهيأت قبل هذا السطر
        $('select').each(function () {
            var instance = $(this).data('select2');
            if (instance) {
                instance.options.set('matcher', select2WordsMatcher);
            }
        });
    }
</script>

<script>
    function viewAttachment(id,url,notes) {
        document.getElementById('viewAttachmentWithId').value = id;
        document.getElementById('view_attachment_result').src = url;
        document.getElementById('download-attachment').href = url;
        document.getElementById('download-attachment').download = 'attachment_'+id;
        // حقل الملاحظات يظهر فقط للمرفقات التي لها ملاحظات، حتى لا تبقى ملاحظات مرفق سابق ظاهرة
        if(notes != null){
            document.getElementById('note_form').style.display = 'block';
            document.getElementById('note_input').value = notes;
        } else {
            document.getElementById('note_form').style.display = 'none';
            document.getElementById('note_input').value = '';
        }
    }

    function notes_edit_for_view_attachment(id,notes) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var headers = {
            "X-CSRF-Token": csrfToken
        };
        $.ajax({
            url: '{{ route('global.update_notes_for_view_attachment_modal_ajax') }}',
            method: 'post',
            headers: headers,
            data: {
                'id':id,
                'notes' : notes,
            },
            success: function(data) {
                if(data.success == 'true'){
                    toastr.success(data.message)
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }

        });
    }
    function viewAttachmentWithId(id) {
        document.getElementById('viewAttachmentWithId').value = id;
    }
    $(document).ready(function() {
        $('#note_input').on('change', function() {
            var notes = $('#note_input').val();
            var id = $('#viewAttachmentWithId').val();
            notes_edit_for_view_attachment(id, notes);
        });
    });
</script>
</body>
</html>
