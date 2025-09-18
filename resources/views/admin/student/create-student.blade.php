
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
        <title>Create Student</title>
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
                            <h4 class="fw-bold py-1 mb-1"><span class="text-muted fw-light">Form/</span>Student</h4>
                            <hr class="my-2" />
                            <!-- Basic Layout & Basic with Icons -->
                            <div class="row">

                                <!-- Basic with Icons -->
                                <div class="col-xxl">
                                    <div class="card mb-4">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h5 class="mb-0">Create New Student</h5>

                                        </div>
                                        <div class="card-body">
                                            <form method="post" action="{{url('/save-student')}}">
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
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Register Number</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-registered"></i
                                                                ></span>
                                                            <input
                                                                type="number"
                                                                class="form-control"
                                                                id="basic-icon-default-fullname"
                                                                name="register_number"
                                                                value="{{old('register_number')}}"
                                                                placeholder="Enter register number"
                                                                aria-label="Enter register number"
                                                                aria-describedby="basic-icon-default-fullname2"
                                                                autofocus="true"
                                                                />
                                                        </div>
                                                        @error('register_number')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Student Name</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-user"></i
                                                                ></span>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                id="basic-icon-default-fullname"
                                                                name="student_name"
                                                                required
                                                                value="{{old('student_name')}}"
                                                                placeholder="Enter student name "
                                                                aria-label="Enter student name "
                                                                aria-describedby="basic-icon-default-fullname2"
                                                                autofocus="true"
                                                                />
                                                        </div>
                                                        @error('student_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Father Name</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-user"></i
                                                                ></span>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                id="basic-icon-default-fullname"
                                                                name="father_name"
                                                                required
                                                                value="{{old('father_name')}}"
                                                                placeholder="Enter Father name "
                                                                aria-label="Enter father name "
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
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Mother Name</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-user"></i
                                                                ></span>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                id="basic-icon-default-fullname"
                                                                name="mother_name"
                                                                required
                                                                value="{{old('mother_name')}}"
                                                                placeholder="Enter Mother name "
                                                                aria-label="Enter Mother name "
                                                                aria-describedby="basic-icon-default-fullname2"
                                                                autofocus="true"
                                                                />
                                                        </div>
                                                        @error('mother_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Student Email</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-mail-send"></i
                                                                ></span>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                id="basic-icon-default-fullname"
                                                                name="student_email"
                                                                required
                                                                value="{{old('student_email')}}"
                                                                placeholder="Enter student emial "
                                                                aria-label="Enter student email "
                                                                aria-describedby="basic-icon-default-fullname2"
                                                                autofocus="true"
                                                                />
                                                        </div>
                                                        @error('student_email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Standard</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-user"></i
                                                                ></span>
                                                            <select  class="form-select" name="standard" required>
                                                            <option >SELECT STANDARD</option>                                                                                                                        
                                                            @foreach ($standards as $standard)
                                                            <option value="{{ $standard->standard }}">{{ $standard->standard }}</option>
                                                            @endforeach                                                            
                                                            </select>
                                                        </div>
                                                        @error('standard')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Select Section</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text">
                                                                <i class="bx bx-user"></i>
                                                            </span>
                                                            <select class="form-select" name="section" required>
                                                                <option value="">SELECT SECTION</option>
                                                                @php
                                                                //Generate an array of letters A to Z
                                                                $letters = range('A', 'Z');
                                                                @endphp
                                                                @foreach ($letters as $letter)
                                                                <option value="{{ $letter }}">{{ $letter }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        @error('section')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Group</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-user"></i
                                                                ></span>
                                                            <select  class="form-select" name="group_id">
                                                            <option value="">SELECT</option>
                                                            @foreach($groupShortNames as $dt)                                                            
                                                            <option value="{{$dt->id}}">{{$dt->group_short_name}}</option>                                                           
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                        @error('group_id')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label">Select Gender</label>
                                                    <div class="col-sm-10 d-flex align-items-start">
                                                        <div class="form-check m-2">
                                                            <input class="form-check-input" type="radio" name="gender" value="male" id="male">
                                                            <label class="form-check-label" for="male">Male</label>
                                                        </div>
                                                        <div class="form-check m-2">
                                                            <input class="form-check-input" type="radio" name="gender" value="female" id="female">
                                                            <label class="form-check-label" for="female">Female</label>
                                                        </div>
                                                        <div class="form-check m-2">
                                                            <input class="form-check-input" type="radio" name="gender" value="other" id="other">
                                                            <label class="form-check-label" for="other">Other</label>
                                                        </div>
                                                        @error('gender')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Previous School</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-user"></i
                                                                ></span>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                id="basic-icon-default-fullname"
                                                                name="previous_school"
                                                                required
                                                                value="{{old('previous_school')}}"
                                                                placeholder="Enter Previous School "
                                                                aria-label="Enter Previous School "
                                                                aria-describedby="basic-icon-default-fullname2"
                                                                autofocus="true"
                                                                />
                                                        </div>
                                                        @error('previous_school')
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
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Emies Number</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-mobile-alt"></i
                                                                ></span>
                                                            <input
                                                                type="number"
                                                                class="form-control"
                                                                id="mobileno"
                                                                name="emies_number"
                                                                onkeyup="return numberValidation(this, 18)"
                                                                value="{{old('emies_number')}}"
                                                                required=""
                                                                placeholder="Enter Emies Number"
                                                                aria-label="Enter Emies Number"
                                                                aria-describedby="basic-icon-default-fullname2"
                                                                autofocus="true"
                                                                />
                                                        </div>
                                                        @error('emies_number')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Aadhar Number</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-mobile-alt"></i
                                                                ></span>
                                                            <input
                                                                type="number"
                                                                class="form-control"
                                                                id="mobileno"
                                                                name="aadhar_number"
                                                                onkeyup="return numberValidation(this, 12)"
                                                                value="{{old('aadhar_number')}}"
                                                                required=""
                                                                placeholder="Enter Aadhar Number"
                                                                aria-label="Enter Aadhar Number"
                                                                aria-describedby="basic-icon-default-fullname2"
                                                                autofocus="true"
                                                                />
                                                        </div>
                                                        @error('aadhar_number')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">dob</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-calendar"></i
                                                                ></span>
                                                            <input
                                                                type="text"
                                                                class="form-control join_date"
                                                                value="{{old('dob')}}"
                                                                name="dob"
                                                                required
                                                                placeholder="dd-mm-yyyy"
                                                                aria-label="Enter dob"
                                                                aria-describedby="basic-icon-default-fullname2"                                                               
                                                                />
                                                        </div>
                                                        @error('dob')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>  

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Academic year</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-calendar-check"></i
                                                                ></span>
                                                            <input
                                                                type="text"
                                                                class="form-control"                                                                
                                                                value="{{old('academic_year')}}"
                                                                name="academic_year"
                                                                id="academic_year"
                                                                required
                                                                placeholder="____-____ "
                                                                aria-label="Enter academic year "
                                                                aria-describedby="basic-icon-default-fullname2"                                                               
                                                                />
                                                        </div>  
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Joined Date</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-calendar"></i
                                                                ></span>
                                                            <input
                                                                type="text"
                                                                class="form-control join_date"
                                                                id="join_date"
                                                                value="{{old('joined_date')}}"
                                                                name="joined_date"
                                                                required
                                                                placeholder="dd-mm-yyyy"
                                                                aria-label="Enter Joined Date"
                                                                aria-describedby="basic-icon-default-fullname2"                                                               
                                                                />
                                                        </div>
                                                        @error('joined_date')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Communication Address</label>
                                                    <div class="col-sm-10">
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-fullname2" class="input-group-text"
                                                                  ><i class="bx bx-calendar-check"></i
                                                                ></span>                                                            
                                                            <textarea 
                                                                class="form-control"
                                                                name="communication_address"
                                                                id="communication-address"
                                                                placeholder="Enter Communication Address"
                                                                aria-label="Enter Communication Address"
                                                                aria-describedby="basic-icon-default-fullname2"
                                                                required> {{old('communication_address')}}</textarea>

                                                        </div>
                                                        @error('communication_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>  
                                                <div class="row justify-content-end">
                                                    <div class="col-sm-10">
                                                        <button type="submit" class="btn btn-info">Save</button>
                                                        <a href="{{url('/student-list')}}" class="btn btn-primary">Show list</a>
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

