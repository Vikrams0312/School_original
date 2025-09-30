<!-- jQuery first -->
<script>
var base_url =<?= json_encode(url('/')) ?>;
</script>
<script src="{{url('public/assets/js/jquery-3.7.1.min.js')}}"></script>
<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{url('public/assets/js/config.js')}}"></script>
<script src="{{url('public/assets/vendor/js/helpers.js')}}"></script>
<!-- Bootstrap & dependencies -->
<script src="{{url('public/assets/vendor/libs/popper/popper.js')}}"></script>
<script src="{{url('public/assets/vendor/js/bootstrap.js')}}"></script>

<!-- Plugins -->
<script src="{{url('public/assets/js/jquery-confirm.js')}}"></script>
<script src="{{url('public/assets/js/bootstrap-multiselect.min.js')}}"></script>
<script src="{{url('public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{url('public/assets/js/choices/choices.min.js')}}"></script>

<!-- Core & App JS -->
<script src="{{url('public/assets/vendor/js/menu.js')}}"></script>
<script src="{{url('public/assets/js/main.js')}}"></script>
<script src="{{url('public/assets/js/develop/school.js?v='.date('YmdHis'))}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
<script src="{{url('public/assets/js/jquery.inputmask.bundle.min.js')}}" type="text/javascript"></script>
