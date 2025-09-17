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
        <title>Create Department</title>
        @include('admin.includes.formcss')
    </head>

    <body>
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
                            <h4 class="fw-bold py-1 mb-1">Group</h4>
                            
                            <!-- Basic Layout & Basic with Icons -->
                            <div class="row">

                                <!-- Basic with Icons -->
                                <div class="col-xxl">
                                    <div class="card mb-4">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h5 class="mb-0"> Create Group</h5>

                                            @if ($errors->any())
                                            <small class="float-end text-danger">
                                                @foreach ($errors->all() as $error)
                                                {{ $error }}
                                                @endforeach
                                            </small>
                                            @endif

                                        </div>
                                        <div class="card-body">
                                            <form method="post" action="{{url('/save-group')}}">
                                                @csrf
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Class </label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-user"></i
                                                                ></span>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                id="basic-icon-default-fullname"
                                                                name="standard"
                                                                required
                                                                value="{{old('standard')}}"
                                                                placeholder="Enter Class"
                                                                aria-label="Enter Class"
                                                                aria-describedby="basic-icon-default-fullname2"
                                                                />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Group name</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-user"></i
                                                                ></span>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                id="basic-icon-default-fullname"
                                                                name="group_name"
                                                                
                                                                value="{{old('group_name')}}"
                                                                placeholder="Enter Group Name"
                                                                aria-label="Enter Group Name"
                                                                aria-describedby="basic-icon-default-fullname2"
                                                                />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-company">Group short name</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-company2" class="input-group-text"
                                                                  ><i class="bx bx-buildings"></i
                                                                ></span>
                                                            <input
                                                                type="text"
                                                                id="basic-icon-default-company"
                                                                class="form-control"
                                                                name="group_short_name"
                                                                
                                                                value="{{old('group_short_name')}}"
                                                                placeholder="Enter Group Short Name"
                                                                aria-label="Enter Group Short Name"
                                                                aria-describedby="basic-icon-default-company2"
                                                                />
                                                        </div>
                                                    </div>
                                                </div>                                                
                                                <div class="row justify-content-end">
                                                    <div class="col-sm-10">
                                                        <button type="submit" class="btn btn-info">Save</button>

                                                        <a href="{{url('/group-list')}}" class="btn btn-primary">Show list</a>

                                                    </div>
                                                </div>
                                            </form>
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

