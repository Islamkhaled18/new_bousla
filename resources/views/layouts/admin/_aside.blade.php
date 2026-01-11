<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

<aside class="app-sidebar">
    <div class="app-sidebar__user">
        <div>
            <p class="app-sidebar__user-name">{{ auth()->user()->name }}</p>
            <p class="app-sidebar__user-designation">{{ auth()->user()->email }}</p>
        </div>
    </div>

    <ul class="app-menu">

        <li><a class="app-menu__item" href="#"><i class="app-menu__icon fa fa-home"></i>
                <span class="app-menu__label">الرئيسية</span></a></li>


        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i
                    class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label"> المشرفين وصلاحياتهم</span><i
                    class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">

                <li><a class="treeview-item" href="#"><i class="app-menu__icon fa fa-user"></i> <span
                            class="app-menu__label">المشرفين</span></a>
                </li>

                <li><a class="treeview-item" href="#"><i class="app-menu__icon fa fa-user"></i>
                        <span class="app-menu__label">اوامر وصلاحيات</span></a></li>
            </ul>
        </li>


        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i
                    class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label"> الاقسام</span><i
                    class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">

                <li><a class="treeview-item" href="{{ route('main-categories.index') }}"><i class="app-menu__icon fa fa-user"></i> <span
                            class="app-menu__label">الاقسام
                            الرئيسيه</span></a></li>

                <li><a class="treeview-item" href="#"><i class="app-menu__icon fa fa-user"></i> <span
                            class="app-menu__label">الاقسام</span></a></li>
            </ul>
        </li>
        <li><a class="app-menu__item" href="#"><i class="app-menu__icon fa fa-user"></i>
                <span class="app-menu__label">الماركات</span></a></li>

        <li><a class="app-menu__item" href="#"><i class="app-menu__icon fa fa-user"></i>
                <span class="app-menu__label">الاعلانات</span></a></li>

        <li><a class="app-menu__item" href="{{ route('job-titles.index') }}"><i class="app-menu__icon fa fa-user"></i>
                <span class="app-menu__label">الوظائف</span></a></li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i
                    class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label"> الاعدادات
                    والسياسات</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">

                <li><a class="treeview-item" href="#"><i class="app-menu__icon fa fa-user"></i>
                        <span class="app-menu__label">الاعدادات</span></a></li>

                <li><a class="treeview-item" href="#"><i class="app-menu__icon fa fa-user"></i>
                        <span class="app-menu__label">الشروط والاحكام </span></a></li>

                <li><a class="treeview-item" href="#"><i class="app-menu__icon fa fa-user"></i> <span
                            class="app-menu__label">
                            عن المنظمة</span></a></li>
            </ul>
        </li>


        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i
                    class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label"> التواصل</span><i
                    class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">

                <li><a class="treeview-item" href="#"><i class="app-menu__icon fa fa-user"></i>
                        <span class="app-menu__label">رسائل المستخدمين او الزوار</span></a></li>
            </ul>
        </li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i
                    class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label"> المناطق الجغرافية
                </span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">

                <li><a class="treeview-item" href="{{ route('governorates.index') }}"><i
                            class="app-menu__icon fa fa-user"></i>
                        <span class="app-menu__label">المحافظات</span></a></li>

                <li><a class="treeview-item" href="{{ route('cities.index') }}"><i class="app-menu__icon fa fa-user"></i>
                        <span class="app-menu__label">المدن</span></a></li>

                <li><a class="treeview-item" href="{{ route('areas.index') }}"><i class="app-menu__icon fa fa-user"></i>
                        <span class="app-menu__label">المناطق</span></a></li>
            </ul>
        </li>



        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i
                    class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label"> العملاء وطلبات الانضمام
                </span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="#"><i class="app-menu__icon fa fa-user"></i>
                        <span class="app-menu__label">طلبات الانضمام</span></a></li>

                <li><a class="treeview-item" href="#"><i class="app-menu__icon fa fa-user"></i>
                        <span class="app-menu__label">العملاء </span></a></li>

            </ul>
        </li>

    </ul>
</aside>
