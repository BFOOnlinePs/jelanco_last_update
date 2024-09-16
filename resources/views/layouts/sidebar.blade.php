<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: {{ !empty(App\Models\SystemSettingModel::first()) ?? App\Models\SystemSettingModel::first()->value('sidebar_color') }}">
    <!-- Brand Logo -->
{{--    <a href="{{ route('home') }}" class="brand-link">--}}
{{--        <img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"--}}
{{--             style="opacity: .8">--}}
{{--        <span class="brand-text font-weight-light">Jelanco</span>--}}
{{--    </a>--}}

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 text-center">
            <a href="{{ route('home') }}">
                <div class="image">
                    <img src="{{ asset('img/jelanco.png') }}" style="width: 60%" class="img-circle elevation-2" alt="User Image">
                </div>
                <h6 class="text-white mt-2">شركة جيلانكو للتجارة والصناعة</h6>
            </a>
            {{--            <div class="info">--}}
{{--                <a href="#" class="d-block">{{ auth()->user()->name }}</a>--}}
{{--            </div>--}}
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                @if(auth()->user()->user_role == 9)

                    <li class="nav-item has-treeview ">
                        <a href="{{ route('users.storekeeper.personal_account',['id'=>auth()->user()->id]) }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                الملف الشخصي
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview ">
                        <a href="{{ route('orders.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                طلبات الشراء بواسطتي
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview ">
                        <a href="{{ route('users.storekeeper.orders.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                جميع طلبات الشراء
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="{{ route('message.send_message_page') }}" class="nav-link">
                            <i class="nav-icon fa fa-message"></i>
                            <p>
                                الرسائل
                            </p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{ route('calendar.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                التقويم
                                                           <span class="right badge badge-danger">New</span>
                            </p>
                        </a>
                    </li> --}}
                    <li class="nav-item">
                        <a href="{{ route('procurement_officer.tasks.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                المهام
                                {{--                            <span class="right badge badge-danger">New</span>--}}
                            </p>
                        </a>
                    </li>
                @elseif(auth()->user()->user_role == 2)
                    <li class="nav-item has-treeview">
                        <a href="{{ route('orders.procurement_officer.order_index') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                طلبات الشراء
                                {{--                            <i class="right fas fa-angle-left"></i>--}}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview ">
                        <a href="{{ route('orders.procurement_officer.listOrderForOfficerIndex') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                طلبات الشراء الخاصة بي
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="{{ route('product.home') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                الأصناف
                                {{--                            <i class="right fas fa-angle-left"></i>--}}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="{{ route('users.supplier.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                الموردين
                                {{--                            <i class="right fas fa-angle-left"></i>--}}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="{{ route('message.send_message_page') }}" class="nav-link">
                            <i class="nav-icon fa fa-message"></i>
                            <p>
                                الرسائل
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('calendar.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                التقويم
                                {{--                            <span class="right badge badge-danger">New</span>--}}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('procurement_officer.tasks.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                المهام
                                {{--                            <span class="right badge badge-danger">New</span>--}}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('note_book.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-note-sticky"></i>
                            <p>
                                دفتر ملاحظاتي
                                {{--                            <span class="right badge badge-danger">New</span>--}}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reports.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-file"></i>
                            <p>
                                التقارير
                                {{--                            <span class="right badge badge-danger">New</span>--}}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="{{ route('setting.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                الاعدادات
                            </p>
                        </a>
                    </li>
                @elseif(auth()->user()->user_role == 3)

                    <li class="nav-item has-treeview menu-open">
                        <a href="{{ route('orders.procurement_officer.order_index') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                طلبات الشراء
                                {{--                            <i class="right fas fa-angle-left"></i>--}}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview menu-open">
                        <a href="{{ route('product.home') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                الأصناف
                                {{--                            <i class="right fas fa-angle-left"></i>--}}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview menu-open">
                        <a href="{{ route('users.supplier.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                الموردين
                                {{--                            <i class="right fas fa-angle-left"></i>--}}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('calendar.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                التقويم
                                {{--                            <span class="right badge badge-danger">New</span>--}}
                            </p>
                        </a>
                    </li>


                @else
                    <li class="nav-item has-treeview menu-open">
                        <a href="{{ route('users.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-user"></i>
                            <p>
                                المستخدمين
                                {{--                            <i class="right fas fa-angle-left"></i>--}}
                            </p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview ">
                        <a href="{{ route('product.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-list"></i>
                            <p>
                                الأصناف
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('orders.procurement_officer.order_index') }}" class="nav-link">
                            <i class="nav-icon fa fa-th-list"></i>
                            <p>
                                طلبات شراء
                                {{--                            <span class="right badge badge-danger">New</span>--}}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('tasks.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-tasks"></i>
                            <p>
                                المهام
                                {{--                            <span class="right badge badge-danger">New</span>--}}
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('calendar.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-calendar"></i>
                            <p>
                                التقويم
                                {{--                            <span class="right badge badge-danger">New</span>--}}
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('reports.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-file"></i>
                            <p>
                                التقارير
                                {{--                            <span class="right badge badge-danger">New</span>--}}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="{{ route('message.send_message_page') }}" class="nav-link">
                            <i class="nav-icon fa fa-message"></i>
                            <p>
                                الرسائل
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('note_book.index') }}" class="nav-link">
                            <i class="nav-icon fa fa-note-sticky"></i>
                            <p>
                                دفتر ملاحظاتي
                                {{--                            <span class="right badge badge-danger">New</span>--}}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="{{ route('setting.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                الاعدادات
                            </p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>
