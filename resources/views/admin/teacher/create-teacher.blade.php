<!DOCTYPE html>
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="assets/"
    data-template="vertical-menu-template-free"
    >
    <head>
        <title>Create Employee</title>

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
                            <h4 class="fw-bold py-1 mb-1">Employee</h4>

                            <!-- Basic Layout & Basic with Icons -->
                            <div class="row">

                                <!-- Basic with Icons -->
                                <div class="col-xxl">
                                    <div class="card mb-4">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h5 class="mb-0">Create New Employee</h5>

                                        </div>
                                        <div class="card-body">
                                            <form method="post" action="{{url('/save-teacher')}}">
                                                @csrf
                                                @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                @endif
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname"> Name</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-user"></i
                                                                ></span>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                id="basic-icon-default-fullname"
                                                                name="teacher_name"
                                                                required
                                                                value="{{old('teacher_name')}}"
                                                                placeholder="Enter teacher name "
                                                                aria-label="Enter teacher name "
                                                                aria-describedby="basic-icon-default-fullname2"
                                                                autofocus="true"
                                                                />
                                                        </div>
                                                        @error('teacher_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Qualification</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-user"></i
                                                                ></span>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                id="basic-icon-default-fullname"
                                                                name="qualification"
                                                                required
                                                                value="{{old('qualification')}}"
                                                                placeholder="Enter qualification"
                                                                aria-label="Enter qualification"
                                                                aria-describedby="basic-icon-default-fullname2"
                                                                autofocus="true"
                                                                />
                                                        </div>
                                                        @error('father_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>                                                
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname"> Email</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-mail-send"></i
                                                                ></span>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                id="basic-icon-default-fullname"
                                                                name="teacher_email"
                                                                required
                                                                value="{{old('teacher_email')}}"
                                                                placeholder="Enter teacher email"
                                                                aria-label="Enter teacher email"
                                                                aria-describedby="basic-icon-default-fullname2"
                                                                autofocus="true"
                                                                />
                                                        </div>
                                                        @error('teacher_email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Password</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-mail-send"></i
                                                                ></span>
                                                            <input
                                                                type="password"
                                                                class="form-control"
                                                                id="basic-icon-default-fullname"
                                                                name="password"
                                                                required
                                                                placeholder="Enter password"
                                                                aria-label="Enter password"
                                                                aria-describedby="basic-icon-default-fullname2"
                                                                />
                                                            @error('password')
                                                            <span class="text-danger">{{ $message }}</span>
                                                            @enderror

                                                        </div>

                                                    </div>
                                                </div>



                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Designation</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-user"></i
                                                                ></span>
                                                            <select name="designation" class="form-select" required>
                                                                <option value="">-- Select designation --</option>
                                                                @foreach($designations as $designation)
                                                                <option value="{{ $designation->id }}">{{ $designation->designation}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @error('designation')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror

                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Experience</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-user"></i
                                                                ></span>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                id="basic-icon-default-fullname"
                                                                name="experience"
                                                                required
                                                                value="{{old('experience')}}"
                                                                placeholder="Enter experience"
                                                                aria-label="Enter experience"
                                                                aria-describedby="basic-icon-default-fullname2"
                                                                autofocus="true"
                                                                />
                                                        </div>
                                                        @error('experience')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Previous Work Station</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-user"></i
                                                                ></span>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                id="basic-icon-default-fullname"
                                                                name="previous_work_station"
                                                                required
                                                                value="{{old('previous_work_station')}}"
                                                                placeholder="Enter previous work station"
                                                                aria-label="Enter previous work station"
                                                                aria-describedby="basic-icon-default-fullname2"
                                                                autofocus="true"
                                                                />
                                                        </div>
                                                        @error('previous_work_station')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">mobile</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-mobile-alt"></i
                                                                ></span>
                                                            <input
                                                                type="number"
                                                                class="form-control"
                                                                id="mobileno"
                                                                name="mobile"
                                                                onkeyup="return numberValidation(this, 10)"
                                                                value="{{old('mobile')}}"
                                                                required=""
                                                                placeholder="Enter mobile"
                                                                aria-label="Enter mobile"
                                                                aria-describedby="basic-icon-default-fullname2"
                                                                autofocus="true"
                                                                />
                                                        </div>
                                                        @error('mobile')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>                                                                                                 

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Join Date</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-calendar"></i
                                                                ></span>
                                                            <input
                                                                type="text"
                                                                class="form-control join_date"
                                                                id="join_date"
                                                                
                                                                name="join_date"
                                                                required
                                                                placeholder="dd-mm-yyyy"
                                                                aria-label="Enter Join Date"
                                                                aria-describedby="basic-icon-default-fullname2"                                                               
                                                                />
                                                        </div>
                                                        @error('join_date')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div> 

                                                <div class="row justify-content-end">
                                                    <div class="col-sm-10">
                                                        <button type="submit" class="btn btn-info">Save</button>
                                                        <a href="{{url('/teacher-list')}}" class="btn btn-primary">Show list</a>
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

