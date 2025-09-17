
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
        <title> Student List</title>
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
                            <h4 class="fw-bold py-1 mb-1"> Student</h4>

                            <!-- Bordered Table -->
                            <div class="card">
                                <h5 class="card-header">Student list</h5>
                                <div class="card-body">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <a class="btn btn-sm btn-primary" href="{{url('/create-student')}}">
                                                            <i class="bx bx-plus-circle me-1" ></i> Add New
                                                        </a>
                                                    </th>
                                                    <th>Roll no.</th>
                                                    <th>Name</th>
                                                    <th>Father</th>
                                                    <th>Mother</th>
                                                    <th>Email</th>
                                                    <th>Group</th>
                                                    <th>Standard</th>
                                                    <th>Section</th>
                                                    <th>Previous School</th>
                                                    <th>Aadhar</th>
                                                    <th>EMIES</th>
                                                    <th>Gender</th>
                                                    <th>Mobile</th>
                                                    <th>DOB</th>
                                                    <th>Joined date</th>
                                                    <th>Academic year</th>
                                                    <th>Address</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @if(count($student)>0)
                                                @foreach($student as $d)
                                                <tr>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button
                                                                type="button"
                                                                class="btn p-0 dropdown-toggle hide-arrow"
                                                                data-bs-toggle="dropdown"
                                                                >
                                                                <i class="bx bx-dots-vertical-rounded"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="{{url('/edit-student/'.$d->id)}}" 
                                                                   ><i class="bx bx-edit-alt me-1" ></i> Edit</a
                                                                >
                                                                <a class="dropdown-item cursor-pointer" data-id="{{$d->id}}"  onclick="return deleteStudent(this);"
                                                                   ><i class="bx bx-trash me-1"></i> Delete</a
                                                                >
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>{{$d->register_number}}</td>
                                                    <td>{{$d->name}}</td>
                                                    <td>{{$d->father_name}}</td>
                                                    <td>{{$d->mother_name}}</td>
                                                    <td>{{$d->email}}</td>
                                                    <td>{{$d->group_short_name}}</td>
                                                    <td>{{$d->standard}}</td>
                                                    <td>{{$d->section}}</td>
                                                    <td>{{$d->previous_school}}</td>
                                                    <td>{{$d->aadhar_number}}</td>
                                                    <td>{{$d->emies_number}}</td>
                                                    <td>{{$d->gender}}</td>
                                                    <td>{{$d->mobile}}</td>
                                                    <td>{{$d->dob}}</td>
                                                    <td>{{$d->join_date}}</td>
                                                    <td>{{$d->academic_year}}</td>
                                                    <td>{{$d->communication_address}}</td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="4" class="text-center">Record Not Found!</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--/ Bordered Table -->


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



