<?php
// SISTEM KUNCI: Cegah akses langsung ke file layout
if (!defined('AKSES_HALAMAN')) {
    header("Location: /perpustakaan/index.php?page=login");
    exit;
}
?>

        </div> </div> </div> <footer class="sticky-footer bg-white py-3 border-top mt-auto">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span class="text-muted">Copyright &copy; <strong style="color: #1cc88a;">Perpusku Digital</strong> 2026</span>
        </div>
    </div>
</footer>

<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<script>
    $(document).ready(function() {
        // Logika Toggle Sidebar
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });

        // Auto-close alert biar gak menutupi layar kelamaan
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 3000);
    });
</script>

<style>
    /* Transisi Sidebar yang Mulus */
    #sidebar-wrapper {
        transition: all 0.3s ease;
    }
    
    #wrapper.toggled #sidebar-wrapper {
        margin-left: -250px;
    }

    @media (max-width: 768px) {
        #wrapper #sidebar-wrapper {
            margin-left: -250px;
        }
        #wrapper.toggled #sidebar-wrapper {
            margin-left: 0;
        }
        #page-content-wrapper {
            margin-left: 0 !important;
            width: 100% !important;
        }
    }
</style>

</body>
</html>