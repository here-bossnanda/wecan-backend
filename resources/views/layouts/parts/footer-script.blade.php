<script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>
<script src="{{asset('assets/js/validator.js')}}"></script>

<script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>

<!-- datepicker -->
<script src="{{asset('assets/libs/air-datepicker/js/datepicker.min.js')}}"></script>
<script src="{{asset('assets/libs/air-datepicker/js/i18n/datepicker.en.js')}}"></script>
<!-- apexcharts -->
<!-- <script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('assets/libs/jquery-knob/jquery.knob.min.js')}}"></script> -->
  <!-- Required datatable js -->
  <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <!-- Buttons examples -->
  <script src="{{asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
  <script src="{{asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
  <script src="{{asset('assets/libs/jszip/jszip.min.js')}}"></script>
  <script src="{{asset('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
  <script src="{{asset('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
  <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
  <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
  <script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
  <!-- Responsive examples -->
  <script src="{{asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
  <script src="{{asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
  <!-- Datatable init js -->
  <script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>
  <!-- Toastr -->
  <script src="{{asset('assets/js/toastr/toastr.js')}}"></script>
  <!-- Sweet-Alert  -->
  <script src="{{asset('assets/libs/sweet-alert2/sweetalert2.min.js')}}"></script>
  <!--  dropify  -->
  <script src="{{asset('assets/libs/dropify-master/dist/js/dropify.min.js')}}"></script>
  <!--  Select2  -->
  <script src="{{asset('assets/libs/select2/dist/js/select2.min.js')}}"></script>
  <!-- dropzone js -->
  <script src="{{asset('assets/libs/dropzone/min/dropzone.min.js')}}"></script>
  <!-- Dual List Box -->
  <script src="{{asset('assets/libs/listviewbox/jquery.lwMultiSelect.js')}}"></script>
  <!-- Summernote js -->
  <script src="{{asset('assets/libs/summernote/summernote-bs4.min.js')}}"></script>

  <script src="{{asset('assets/js/app.js')}}"></script>
  <script type="text/javascript">
  $( document ).ready(function() {
  $('input').attr('autocomplete','off');
  });

  // autologout.js
$(document).ready(function () {
  const timeout = 900000;  // 900000 ms = 15 minutes
  // $("input[required], select[required]").attr("oninvalid", "this.setCustomValidity('Inputan tidak boleh kosong, silakan isi inputan diatas!')");
  // $("input[required], select[required]").attr("oninput", "setCustomValidity('')");
  var idleTimer = null;
  $('*').bind('mousemove click mouseup mousedown keydown keypress keyup submit change mouseenter scroll resize dblclick', function () {
      clearTimeout(idleTimer);

      idleTimer = setTimeout(function () {
          document.getElementById('logout-form').submit();
      }, timeout);
  });
  $("body").trigger("mousemove");
});
</script>

  @stack('scripts')