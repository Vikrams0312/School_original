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
        <title> Payment History</title>
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
                            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Table /</span> Payment History</h4>

                            <hr class="my-5" />

                            <!-- Bordered Table -->
                            <div class="card">
                                <h5 class="card-header">Payment history list</h5>
                                <div class="card-body">

                                    <form method="post"  action="{{url('/#')}}">
                                        @csrf
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
                                                        id="register_number"
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
                                        <div class="row mb-3 justify-content-end">
                                            <div class="col-sm-10">
                                                <button type="button" id="" class="btn btn-info btn-sm" onclick="return getStudentDetailsForPaymentHistory(this);"><i class="bx bx-check-circle"></i> Submit</button>                                                        
                                            </div>
                                        </div>
                                        <div id="student_details"></div>
                                        <div id="payment_history"></div>
                                        
                                    </form>


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


