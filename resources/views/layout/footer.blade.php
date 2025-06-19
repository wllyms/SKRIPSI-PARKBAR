<!-- Footer -->
</div>
</div>
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>copyright &copy;
                <script>
                    document.write(new Date().getFullYear());
                </script> - developed by
                <b><a href="https://www.instagram.com/smthwllyms/" target="_blank">SmithWillyams</a></b>
            </span>
        </div>
    </div>
</footer>
<!-- Footer -->

<script src="{{ asset('tempe1/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('tempe1/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('tempe1/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('tempe1/js/ruang-admin.min.js') }}"></script>
<script src="{{ asset('tempe1/vendor/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('tempe1/js/demo/chart-area-demo.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script> --}}

<!-- Data Tables -->

<script src="{{ asset('tempe1/vendor/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('tempe1/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script>
    $(document).ready(function() {
        $("#dataTable").DataTable(); // ID From dataTable
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const iconToggle = document.getElementById('iconToggle');

        toggle.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            iconToggle.classList.toggle('fa-eye');
            iconToggle.classList.toggle('fa-eye-slash');
        });
    });
</script>

</body>

</html>
