{{--
    AjaxSearch: أساسيات البحث بالـ AJAX لكل صفحات النظام.

    1) AjaxSearch.bind(selector, callback, {delay})
       يربط حقل بحث بدالة التحميل:
       - debounce: ينتظر المستخدم يوقف كتابة (DEFAULT_DELAY) وبعدها ينفّذ طلب واحد بس.
       - Enter ينفّذ البحث فوراً وما بيعمل submit للفورم.
       - ما بيرسل طلب إذا النص ما تغيّر فعلياً (أسهم، Shift، كتابة حرف ومسحه، مسافة بالآخر...).

    2) AjaxSearch.request(key, ajaxOptions)
       نفس $.ajax، بس أي طلب جديد بنفس الـ key بيلغي (abort) الطلب السابق اللي لسا ما رجع،
       فما في رد قديم بيكتب فوق نتيجة أحدث. الطلب الملغي ما بيستدعي error ولا complete
       (يعني ما بيطلع alert، وما بيختفي الـ loader والطلب الجديد لسا شغال).
       استخدمه لتحميل الجداول ونتائج البحث فقط، مش لعمليات الحفظ/التعديل/الحذف.

    ملاحظة: بنقرأ window.jQuery وقت الاستدعاء لأنه في صفحات بتعيد تحميل jQuery،
    وبالتالي $.ajaxSetup تبع الصفحة بيكون على النسخة الجديدة.
--}}
<script>
    window.AjaxSearch = (function () {
        'use strict';

        var DEFAULT_DELAY = 500;
        var pending = {};

        function abort(key) {
            var xhr = pending[key];
            delete pending[key];
            if (xhr && xhr.readyState !== 4) {
                xhr.abort();
            }
        }

        function isPending(key) {
            return Object.prototype.hasOwnProperty.call(pending, key);
        }

        function request(key, options) {
            abort(key);

            var jq = window.jQuery;
            var settings = jq.extend({}, options);
            var onError = settings.error;
            var onComplete = settings.complete;
            var xhr;

            settings.error = function (jqXHR, textStatus) {
                if (textStatus !== 'abort' && typeof onError === 'function') {
                    onError.apply(this, arguments);
                }
            };
            settings.complete = function (jqXHR, textStatus) {
                if (pending[key] === xhr) {
                    delete pending[key];
                }
                if (textStatus !== 'abort' && typeof onComplete === 'function') {
                    onComplete.apply(this, arguments);
                }
            };

            xhr = jq.ajax(settings);
            // beforeSend ممكن يرجّع false فيتلغى الطلب قبل ما ينبعث
            if (xhr.state() === 'pending') {
                pending[key] = xhr;
            }
            return xhr;
        }

        function matches(el, selector) {
            if (!el || el.nodeType !== 1) {
                return false;
            }
            var fn = el.matches || el.msMatchesSelector || el.webkitMatchesSelector;
            return fn.call(el, selector);
        }

        function normalize(value) {
            return String(value == null ? '' : value).trim();
        }

        function bind(selector, callback, options) {
            var delay = options && options.delay != null ? options.delay : DEFAULT_DELAY;
            var states = new WeakMap();

            function stateOf(el) {
                var state = states.get(el);
                if (!state) {
                    state = {timer: null, before: undefined};
                    states.set(el, state);
                }
                return state;
            }

            function run(el, force) {
                var state = stateOf(el);
                var unchanged = state.before !== undefined && normalize(el.value) === normalize(state.before);

                clearTimeout(state.timer);
                state.timer = null;
                state.before = undefined;

                if (force || !unchanged) {
                    callback.call(el, el.value, el);
                }
            }

            document.addEventListener('keydown', function (e) {
                var el = e.target;
                if (!matches(el, selector)) {
                    return;
                }
                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();
                    run(el, true);
                    return;
                }
                // القيمة قبل أول حرف بهاي الدفعة من الكتابة، عشان نعرف اذا تغيّرت فعلاً
                var state = stateOf(el);
                if (!state.timer) {
                    state.before = el.value;
                }
            });

            document.addEventListener('input', function (e) {
                var el = e.target;
                if (!matches(el, selector)) {
                    return;
                }
                var state = stateOf(el);
                clearTimeout(state.timer);
                state.timer = setTimeout(function () {
                    run(el, false);
                }, delay);
            });

            // القيمة ممكن تتغير برمجياً وهو برا الحقل (زر "الغاء البحث" مثلاً)
            document.addEventListener('focusout', function (e) {
                if (matches(e.target, selector) && !stateOf(e.target).timer) {
                    stateOf(e.target).before = undefined;
                }
            });
        }

        return {
            bind: bind,
            request: request,
            abort: abort,
            isPending: isPending
        };
    })();
</script>
