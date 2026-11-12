{{--
    ترقيم صفحات تلقائي لكل جداول النظام (التنسيق في theme.css، قسم Pagination)
    - يُطبَّق على أي جدول فيه أكثر من 10 صفوف، بما فيها الجداول التي تُحمَّل لاحقاً بـ AJAX
    - لا يُطبَّق على: الجداول المتداخلة، جداول DataTables، والجداول التي عليها data-paginate="false"
      (تُستخدم للجداول التي لها ترقيم من السيرفر ->links())
    - أزرار الترقيم <button> وليست <a> حتى لا تلتقطها معالجات $(document).on('click', '.pagination a') الموجودة في بعض الصفحات
    - يُحمَّل بعد @yield('script') حتى تأخذ جداول DataTables إعدادات اللغة العربية قبل تهيئتها
--}}
<script>
    if ($.fn.dataTable) {
        $.extend(true, $.fn.dataTable.defaults, {
            language: {
                processing: 'جارٍ التحميل...',
                search: 'بحث:',
                lengthMenu: 'عرض _MENU_ صفوف',
                info: 'عرض _START_ إلى _END_ من أصل _TOTAL_',
                infoEmpty: 'لا توجد بيانات',
                infoFiltered: '(من أصل _MAX_)',
                zeroRecords: 'لا توجد نتائج مطابقة',
                emptyTable: 'لا توجد بيانات',
                paginate: {first: 'الأول', previous: 'السابق', next: 'التالي', last: 'الأخير'}
            }
        });
    }

    (function () {
        'use strict';

        var SIZES = [10, 25, 50, 100];
        var STORAGE_KEY = 'jl.tablePageSize';

        function savedSize() {
            try {
                var v = parseInt(localStorage.getItem(STORAGE_KEY), 10);
                return SIZES.indexOf(v) > -1 ? v : SIZES[0];
            } catch (e) {
                return SIZES[0];
            }
        }

        function saveSize(v) {
            try { localStorage.setItem(STORAGE_KEY, String(v)); } catch (e) {}
        }

        // صفوف البيانات المباشرة للجدول (tBodies لا تشمل صفوف الجداول المتداخلة)
        // صف عناوين داخل tbody (جدول بدون thead وأول صف كله th) يبقى ظاهراً دائماً
        function dataRows(table) {
            var rows = [];
            for (var i = 0; i < table.tBodies.length; i++) {
                rows.push.apply(rows, table.tBodies[i].rows);
            }
            if (!table.tHead && rows.length && !rows[0].querySelector('td')) {
                rows.shift();
            }
            return rows;
        }

        function isManagedElsewhere(table) {
            if (table.getAttribute('data-paginate') === 'false') return true;
            if (table.parentElement && table.parentElement.closest('table')) return true;
            if (table.closest('.dataTables_wrapper')) return true;
            if ($.fn.dataTable && $.fn.dataTable.isDataTable(table)) return true;
            return false;
        }

        function pagerAnchor(table) {
            var p = table.parentElement;
            return p && p.classList.contains('table-responsive') ? p : table;
        }

        function pageList(current, last) {
            var pages = [1];
            for (var p = Math.max(2, current - 1); p <= Math.min(last - 1, current + 1); p++) {
                pages.push(p);
            }
            if (last > 1) pages.push(last);
            var out = [];
            for (var i = 0; i < pages.length; i++) {
                if (i && pages[i] - pages[i - 1] > 1) out.push('…');
                out.push(pages[i]);
            }
            return out;
        }

        function pageButton(label, page, opts) {
            opts = opts || {};
            var li = '<li class="page-item' + (opts.active ? ' active' : '') + (opts.disabled ? ' disabled' : '') + '"' +
                (opts.active ? ' aria-current="page"' : '') + '>';
            if (opts.disabled || opts.active) {
                return li + '<span class="page-link"' + (opts.aria ? ' aria-label="' + opts.aria + '"' : '') + '>' + label + '</span></li>';
            }
            return li + '<button type="button" class="page-link" data-page="' + page + '"' +
                (opts.aria ? ' aria-label="' + opts.aria + '"' : '') + '>' + label + '</button></li>';
        }

        function render(table) {
            var st = table._jlPager;
            var total = st.rows.length;
            var last = Math.max(1, Math.ceil(total / st.size));
            st.page = Math.min(Math.max(1, st.page), last);
            var from = (st.page - 1) * st.size;
            var to = Math.min(from + st.size, total);

            for (var i = 0; i < total; i++) {
                st.rows[i].classList.toggle('jl-pager-hidden', i < from || i >= to);
            }

            var html = pageButton('<span class="fas fa-chevron-right" aria-hidden="true"></span>', st.page - 1,
                {disabled: st.page === 1, aria: 'الصفحة السابقة'});
            pageList(st.page, last).forEach(function (p) {
                html += p === '…'
                    ? '<li class="page-item disabled"><span class="page-link">…</span></li>'
                    : pageButton(p, p, {active: p === st.page, aria: 'الصفحة ' + p});
            });
            html += pageButton('<span class="fas fa-chevron-left" aria-hidden="true"></span>', st.page + 1,
                {disabled: st.page === last, aria: 'الصفحة التالية'});

            st.el.querySelector('.jl-pager__pages').innerHTML = html;
            st.el.querySelector('.jl-pager__info').innerHTML =
                'عرض <b>' + (from + 1) + '–' + to + '</b> من <b>' + total + '</b>';
        }

        function attach(table, rows) {
            var size = savedSize();
            var el = document.createElement('div');
            el.className = 'jl-pager';
            el.setAttribute('role', 'navigation');
            el.setAttribute('aria-label', 'صفحات الجدول');
            el.innerHTML =
                '<div class="jl-pager__info" aria-live="polite"></div>' +
                '<div class="jl-pager__controls">' +
                    '<label class="jl-pager__size">عدد الصفوف ' +
                        '<select class="custom-select custom-select-sm">' +
                            SIZES.map(function (s) {
                                return '<option value="' + s + '"' + (s === size ? ' selected' : '') + '>' + s + '</option>';
                            }).join('') +
                        '</select>' +
                    '</label>' +
                    '<ul class="pagination pagination-sm mb-0 jl-pager__pages"></ul>' +
                '</div>';

            var anchor = pagerAnchor(table);
            anchor.parentNode.insertBefore(el, anchor.nextSibling);
            el._jlTable = table;

            table._jlPager = {el: el, rows: rows, size: size, page: 1};

            el.addEventListener('click', function (e) {
                var btn = e.target.closest('button[data-page]');
                if (!btn) return;
                table._jlPager.page = parseInt(btn.getAttribute('data-page'), 10);
                render(table);
                var top = table.getBoundingClientRect().top;
                if (top < 0) {
                    table.scrollIntoView({block: 'start', behavior: 'smooth'});
                }
            });

            el.querySelector('select').addEventListener('change', function () {
                var st = table._jlPager;
                var firstShown = (st.page - 1) * st.size;
                st.size = parseInt(this.value, 10);
                st.page = Math.floor(firstShown / st.size) + 1;
                saveSize(st.size);
                render(table);
            });

            render(table);
        }

        function detach(table) {
            var st = table._jlPager;
            st.rows.forEach(function (r) { r.classList.remove('jl-pager-hidden'); });
            if (st.el.parentNode) st.el.parentNode.removeChild(st.el);
            delete table._jlPager;
        }

        function sync(table) {
            var st = table._jlPager;
            var managed = isManagedElsewhere(table);
            var rows = managed ? [] : dataRows(table);

            if (!st) {
                if (!managed && rows.length > SIZES[0]) attach(table, rows);
                return;
            }
            if (managed || rows.length <= SIZES[0]) {
                detach(table);
                return;
            }
            // الصفوف تغيّرت (حذف / إضافة / إعادة تحميل) فقط عندها نعيد الرسم
            if (rows.length === st.rows.length && rows[0] === st.rows[0] && rows[rows.length - 1] === st.rows[st.rows.length - 1]) {
                return;
            }
            var added = rows.length > st.rows.length && rows[rows.length - 1] !== st.rows[st.rows.length - 1];
            st.rows.forEach(function (r) { r.classList.remove('jl-pager-hidden'); });
            st.rows = rows;
            // صف جديد أُضيف في آخر الجدول: ننتقل لآخر صفحة حتى يظهر للمستخدم
            if (added) st.page = Math.ceil(rows.length / st.size);
            render(table);
        }

        function scan() {
            // شريط ترقيم بقي بعد أن استبدل AJAX الجدول نفسه
            var pagers = document.querySelectorAll('.jl-pager');
            for (var j = 0; j < pagers.length; j++) {
                var owner = pagers[j]._jlTable;
                if (!owner || !owner.isConnected || !owner._jlPager || owner._jlPager.el !== pagers[j]) {
                    pagers[j].parentNode.removeChild(pagers[j]);
                }
            }

            var tables = document.querySelectorAll('table');
            for (var i = 0; i < tables.length; i++) sync(tables[i]);
        }

        var pending = null;

        function schedule() {
            if (pending) return;
            pending = setTimeout(function () {
                pending = null;
                scan();
            }, 60);
        }

        $(function () {
            scan();
            // الجداول التي تُحمَّل أو تتغير لاحقاً (AJAX، حذف صف، تهيئة DataTables متأخرة)
            new MutationObserver(schedule).observe(document.body, {childList: true, subtree: true});
        });
    })();
</script>
