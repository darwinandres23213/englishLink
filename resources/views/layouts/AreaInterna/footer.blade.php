
</div> <!-- End of Main Content -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="footer-bottom text-center my-auto"> <!-- div class="copyright text-center my-auto"-->
            <p>&copy; {{ date('Y') }} EnglishLink. Todos los derechos reservados.</p>
        </div>
    </div>
</footer> {{-- ...ventanas modales, íconos, chat, scripts JS, etc... --}}




<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>




<!-- Logout Modal-->
{{-- <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <!-- ...modal code... -->
</div> --}}

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>
<script src="{{ asset('js/users.js') }}"></script>
{{-- ...otros scripts y JS personalizados... --}}

@stack('scripts')