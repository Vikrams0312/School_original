<?php
$title = "Payment Success";
if (isset($payment_status) && $payment_status == 1) {
    $title = "Payment Success";
} else {
    $title = "Payment Failed";
}
$payment_status = 1;
?>
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
        <title>{{$title}}</title>
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
                            <h4 class="fw-bold py-3 mb-4">Transaction Status</h4>
                            <!-- Basic Layout & Basic with Icons -->
                            <div class="row">
                                <!-- Basic with Icons -->
                                <div class="col-xxl">
                                    @if($payment_status==1)
                                    <div class="card mb-4">
                                        <div class="card card-body">                                            
                                            <div class="alert alert-success text-center">
                                                <i class="bx bx-check-circle"></i> 
                                                <p>Your payment has been made successfully!..</p>
                                                <a href="{{url('/paymentHistory')}}" class="btn btn-dark">Check Payment History</a>
                                            </div>
                                        </div>
                                    </div>
                                    @elseif($payment_status==0)
                                    <div class="card mb-4">
                                        <div class="card card-body">                                            
                                            <div class="alert alert-danger text-center">
                                                <i class="bx bx-x-circle"></i> 
                                                <p>Your payment failed. <a href="{{url('/createPayment')}}">Please click to pay again..</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
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

