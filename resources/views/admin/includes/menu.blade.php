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
        <!-- Account Settings -->
        <li class="menu-item {{ in_array($url_segment, ['account-settings-account', 'account-settings-notifications', 'account-settings-connections']) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Account Settings</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $url_segment == 'account-settings-account' ? 'active' : '' }}">
                    <a href="pages-account-settings-account.html" class="menu-link">
                        <div data-i18n="Account">Account</div>
                    </a>
                </li>
                <li class="menu-item {{ $url_segment == 'account-settings-notifications' ? 'active' : '' }}">
                    <a href="pages-account-settings-notifications.html" class="menu-link">
                        <div data-i18n="Notifications">Notifications</div>
                    </a>
                </li>
                <li class="menu-item {{ $url_segment == 'account-settings-connections' ? 'active' : '' }}">
                    <a href="pages-account-settings-connections.html" class="menu-link">
                        <div data-i18n="Connections">Connections</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Authentications -->
        <li class="menu-item {{ in_array($url_segment, ['auth-login-basic', 'auth-register-basic', 'auth-forgot-password-basic']) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
                <div data-i18n="Authentications">Authentications</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $url_segment == 'auth-login-basic' ? 'active' : '' }}">
                    <a href="auth-login-basic.html" class="menu-link" target="_blank">
                        <div data-i18n="Basic">Login</div>
                    </a>
                </li>
                <li class="menu-item {{ $url_segment == 'auth-register-basic' ? 'active' : '' }}">
                    <a href="auth-register-basic.html" class="menu-link" target="_blank">
                        <div data-i18n="Basic">Register</div>
                    </a>
                </li>
                <li class="menu-item {{ $url_segment == 'auth-forgot-password-basic' ? 'active' : '' }}">
                    <a href="auth-forgot-password-basic.html" class="menu-link" target="_blank">
                        <div data-i18n="Basic">Forgot Password</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- Misc -->
        <li class="menu-item {{ in_array($url_segment, ['pages-misc-error', 'pages-misc-under-maintenance']) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cube-alt"></i>
                <div data-i18n="Misc">Misc</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $url_segment == 'pages-misc-error' ? 'active' : '' }}">
                    <a href="pages-misc-error.html" class="menu-link">
                        <div data-i18n="Error">Error</div>
                    </a>
                </li>
                <li class="menu-item {{ $url_segment == 'pages-misc-under-maintenance' ? 'active' : '' }}">
                    <a href="pages-misc-under-maintenance.html" class="menu-link">
                        <div data-i18n="Under Maintenance">Under Maintenance</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Components header -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Components</span></li>

        <!-- Cards -->
        <li class="menu-item {{ $url_segment == 'cards-basic' ? 'active' : '' }}">
            <a href="cards-basic.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Cards</div>
            </a>
        </li>

        <!-- User Interface -->
        <li class="menu-item {{ in_array($url_segment, [
            'ui-accordion', 'ui-alerts', 'ui-badges', 'ui-buttons', 'ui-carousel',
            'ui-collapse', 'ui-dropdowns', 'ui-footer', 'ui-list-groups',
            'ui-modals', 'ui-navbar', 'ui-offcanvas', 'ui-pagination-breadcrumbs',
            'ui-progress', 'ui-spinners', 'ui-tabs-pills', 'ui-toasts', 'ui-tooltips-popovers', 'ui-typography'
        ]) ? 'active open' : '' }}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-box"></i>
                <div data-i18n="User interface">User interface</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $url_segment == 'ui-accordion' ? 'active' : '' }}">
                    <a href="ui-accordion.html" class="menu-link">
                        <div data-i18n="Accordion">Accordion</div>
                    </a>
                </li>
                <!-- Add other UI items similarly -->
            </ul>
        </li>

        <!-- Extended UI -->
        <li class="menu-item {{ in_array($url_segment, ['extended-ui-perfect-scrollbar', 'extended-ui-text-divider']) ? 'active open' : '' }}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-copy"></i>
                <div data-i18n="Extended UI">Extended UI</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $url_segment == 'extended-ui-perfect-scrollbar' ? 'active' : '' }}">
                    <a href="extended-ui-perfect-scrollbar.html" class="menu-link">
                        <div data-i18n="Perfect Scrollbar">Perfect scrollbar</div>
                    </a>
                </li>
                <li class="menu-item {{ $url_segment == 'extended-ui-text-divider' ? 'active' : '' }}">
                    <a href="extended-ui-text-divider.html" class="menu-link">
                        <div data-i18n="Text Divider">Text Divider</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Boxicons -->
        <li class="menu-item {{ $url_segment == 'icons-boxicons' ? 'active' : '' }}">
            <a href="icons-boxicons.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-crown"></i>
                <div data-i18n="Boxicons">Boxicons</div>
            </a>
        </li>

        <!-- Forms & Tables Header -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Forms &amp; Tables</span></li>

        <!-- Form Elements -->
        <li class="menu-item {{ in_array($url_segment, ['forms-basic-inputs', 'forms-input-groups']) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div data-i18n="Form Elements">Form Elements</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $url_segment == 'forms-basic-inputs' ? 'active' : '' }}">
                    <a href="forms-basic-inputs.html" class="menu-link">
                        <div data-i18n="Basic Inputs">Basic Inputs</div>
                    </a>
                </li>
                <li class="menu-item {{ $url_segment == 'forms-input-groups' ? 'active' : '' }}">
                    <a href="forms-input-groups.html" class="menu-link">
                        <div data-i18n="Input groups">Input groups</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Form Layouts -->
        <li class="menu-item {{ in_array($url_segment, ['form-layouts-vertical', 'form-layouts-horizontal']) ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div data-i18n="Form Layouts">Form Layouts</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ $url_segment == 'form-layouts-vertical' ? 'active' : '' }}">
                    <a href="form-layouts-vertical.html" class="menu-link">
                        <div data-i18n="Vertical Form">Vertical Form</div>
                    </a>
                </li>
                <li class="menu-item {{ $url_segment == 'form-layouts-horizontal' ? 'active' : '' }}">
                    <a href="form-layouts-horizontal.html" class="menu-link">
                        <div data-i18n="Horizontal Form">Horizontal Form</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Tables -->
        <li class="menu-item {{ $url_segment == 'tables-basic' ? 'active' : '' }}">
            <a href="tables-basic.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="Tables">Tables</div>
            </a>
        </li>

        <!-- Support -->
        <li class="menu-item">
            <a href="https://github.com/themeselection/sneat-html-admin-template-free/issues" target="_blank" class="menu-link">
                <i class="menu-icon tf-icons bx bx-support"></i>
                <div data-i18n="Support">Support</div>
            </a>
        </li>

        <!-- Documentation -->
        <li class="menu-item">
            <a href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/" target="_blank" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Documentation">Documentation</div>
            </a>
        </li>
    </ul>
</aside>
