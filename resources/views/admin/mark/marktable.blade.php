<!DOCTYPE html>
<!-- beautify ignore:start -->
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="assets/"
    data-template="vertical-menu-template-free"
    >
    <head>
        <title>Assign Mark Table</title>
        @include('admin.includes.formcss')
    </head>

    <body data-success="{{ session('success') ? 'true' : 'false' }}">

        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                <!-- Menu -->
                @include('admin.includes.menu')
                <!-- / Menu -->
                <!-- Layout container -->
                <div class="layout-page">
                    <!-- Navbar -->
                    @include('admin.includes.nav')
                    <!-- / Navbar -->
                    <!-- Content wrapper -->
                    <div class="content-wrapper">
                        <!-- Content -->
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <h4 class="fw-bold py-1 mb-1">Mark Table</h4>

                            <hr class="my-2" />

                            <!-- Basic Layout & Basic with Icons -->
                            <div class="row">
                                <!-- Basic with Icons -->
                                <div class="col-xxl">
                                    <div class="card mb-4">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h5 class="mb-0"> Create Marktable</h5>
                                        </div>
                                        <div class="card-body">
                                            @if(session('success'))
                                            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>           
                                            @endif

                                            @if(session('error'))
                                            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                                                {{ session('error') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                            @endif
                                            <form  id="filterForm" method="GET" action="{{ url('/marktable') }}">
                                                <div class="row mb-3">
                                                    <!-- Standard Dropdown -->
                                                    <div class="col-md-3">
                                                        <label for="standard" class="form-label">Class</label>
                                                        <select name="standard" id="standard" class="form-select" onchange="toggleGroup()" required>
                                                            <option value="">Select Class</option>
                                                            @foreach($standards as $std)
                                                            <option value="{{ $std->standard }}" 
                                                                    {{ request('standard') == $std->standard ? 'selected' : '' }}>
                                                                {{ $std->standard }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Group Dropdown -->
                                                    <div class="col-md-3">
                                                        <label for="group" class="form-label">Group</label>
                                                        <select name="group" id="group" class="form-select"
                                                                {{ request('standard') && request('standard') <= 10 ? 'disabled' : '' }} required>
                                                            <option value="">Select Group</option>
                                                            @foreach($groups as $grp)
                                                            <option value="{{ $grp->id }}" 
                                                                    {{ request('group') == $grp->id ? 'selected' : '' }}>
                                                                {{ $grp->group_short_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Academic Year Dropdown -->
                                                    <div class="col-md-3">
                                                        <label for="academic_year" class="form-label">Academic Year</label>
                                                        <select name="academic_year" id="academic_year" class="form-select" required>
                                                            <option value="">Select Academic Year</option>
                                                            @foreach($academic_year as $year)
                                                            <option value="{{ $year->academic_year }}" 
                                                                    {{ request('academic_year') == $year->academic_year ? 'selected' : '' }}>
                                                                {{ $year->academic_year }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Submit button -->
                                                    <div class="col-md-2 mt-4">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            </form>


                                            {{-- Only show subjects if NO success message --}}
                                            @if(isset($subjects) && count($subjects) > 0 && !session('success'))
                                            <div class="mt-3">
                                                <h5>Subjects</h5>
                                                <ul>
                                                    @foreach($subjects as $sub)
                                                    <li>{{ $sub->subject_name }}</li>
                                                    @endforeach
                                                </ul>

                                                <!-- Separate form for Create Table -->
                                                <form method="POST" id="createTableForm"action="{{ url('/create-mark-table') }}">
                                                    @csrf
                                                    <input type="hidden" name="standard" value="{{ request('standard') }}">
                                                    <input type="hidden" name="group" value="{{ request('group') }}">
                                                    <input type="hidden" name="academic_year" value="{{ request('academic_year') }}">

                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                        Create Table
                                                    </button>
                                                </form>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- / Content -->
                        <!-- Footer -->
                        @include('admin.includes.footer')
                        <!-- / Footer -->
                        <div class="content-backdrop fade"></div>
                    </div>
                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- / Layout wrapper -->

        @include('admin.includes.floatmsg')

        <!-- Core JS -->
        @include('admin.includes.formjs')
      



    </body>
</html>

