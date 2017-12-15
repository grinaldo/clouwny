<!-- jQuery -->
<script src="{{ asset('assets/admin/vendors/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('assets/admin/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('assets/admin/vendors/fastclick/lib/fastclick.js') }}"></script>
<!-- NProgress -->
<script src="{{ asset('assets/admin/vendors/nprogress/nprogress.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('assets/admin/vendors/iCheck/icheck.min.js') }}"></script>
<!-- Datatables -->
<script src="{{ asset('assets/admin/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
<script src="{{ asset('assets/admin/vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendors/jszip/dist/jszip.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendors/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendors/pdfmake/build/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/admin/vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

{{-- <script src="{{ asset('packages/barryvdh/elfinder/js/elfinder.min.js') }}"></script> --}}
{{-- <script src="{{ asset('packages/barryvdh/elfinder/js/tiny_mce_popup.js') }}"></script> --}}
<script src="{{ asset('assets/admin/vendors/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('packages/barryvdh/elfinder/js/standalonepopup.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/admin/global/plugins/colorbox/jquery.colorbox-min.js') }}"></script>
<!-- Custom Theme Scripts -->
<script src="{{ asset('assets/admin/js/custom.js') }}"></script>
<script src="{{ asset('assets/admin/js/form.js') }}"></script>
<script>var urlPrefix = "{{ asset('/') }}";</script>
<script>
jQuery(document).ready(function() {
    FormField.init()
});
</script>