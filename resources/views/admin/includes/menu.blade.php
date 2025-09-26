@php
use Illuminate\Support\Str;
$url_segment = Request::segment(1);
@endphp


<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ url('/dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <!-- SVG Logo code here -->
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">Glorex</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ $url_segment == 'dashboard' ? 'active' : '' }}">
            <a href="{{ url('/dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Student Menu -->
        <li class="menu-item {{ in_array($url_segment, ['student-list','studentType','departmentList']) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Student">Student</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $url_segment == 'student-list' ? 'active' : '' }}">
                    <a href="{{ url('/student-list') }}" class="menu-link">
                        <div data-i18n="Without menu">Student List</div>
                    </a>
                </li>

            </ul>
        </li>
        <!-- Teacher List -->
        <li class="menu-item {{ in_array($url_segment, ['teacher-list']) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Teacher">Employee</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $url_segment == 'teacher-list' ? 'active' : '' }}">
                    <a href="{{ url('/teacher-list') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-user"></i>
                        <div data-i18n="teacher-list">Teacher List</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Teacher List -->

        <li class="menu-item {{ $url_segment == 'group-list' ? 'active' : '' }}">
            <a href="{{ url('/group-list') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book"></i>
                <div data-i18n="group-list">Group List</div>
            </a>
        </li>

        <!-- Subject List -->
        <li class="menu-item {{ $url_segment == 'subject-list' ? 'active' : '' }}">
            <a href="{{ url('/subject-list') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-open"></i>
                <div data-i18n="Subjectlist">Subject List</div>
            </a>
        </li>

        <!-- Subject List -->
        <li class="menu-item {{ $url_segment == 'create-subject-allotment' ? 'active' : '' }}">
            <a href="{{ url('/create-subject-allotment') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-open"></i>
                <div data-i18n="Subjectallotment">Subject Allotment</div>
            </a>
        </li>

        <li class="menu-item {{ $url_segment == 'designation-list' ? 'active' : '' }}">
            <a href="{{ url('/designation-list') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-id-card"></i>
                <div data-i18n="Designation">Designation Lists</div>
            </a>
        </li>
        <li class="menu-item {{ $url_segment == 'create-exams' ? 'active' : '' }}">
            <a href="{{ url('/create-exams') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-id-card"></i>
                <div data-i18n="createexams">Create Exams</div>
            </a>
        </li>
        <li class="menu-item {{ $url_segment == 'marktable' ? 'active' : '' }}">
            <a href="{{ url('/marktable') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-id-card"></i>
                <div data-i18n="Marksheet">Create Mark Table</div>
            </a>
        </li>
        <li class="menu-item {{ $url_segment == 'mark-entry' ? 'active' : '' }}">
            <a href="{{ url('/mark-entry') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-id-card"></i>
                <div data-i18n="Markentry"> Mark Entry</div>
            </a>
        </li>
       
    </ul>
</aside>
