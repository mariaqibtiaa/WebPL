<!-- START FOOTER -->
<footer class="page-footer #b71c1c red darken-4">
    <div class="footer-copyright">
        <div class="container">
            <?php
            $query = mysqli_query($config, "SELECT * FROM tbl_instansi");
            while ($data = mysqli_fetch_array($query)) {
            ?>
                <span>Copyright © <?php echo date("Y"); ?>
                    <?php
                    if (!empty($data['nama'])) {
                        echo $data['nama'];
                    } else {
                        echo 'PT. Dagsap Endura Eatore';
                    }
                    ?></span>
            <?php
            }
            ?>

        </div>
    </div>
</footer>
<!-- END FOOTER -->
<!-- ================================================
    Scripts
    ================================================ -->
<!-- jQuery Library -->
<script type="text/javascript" src="asset/vendors/jquery-3.2.1.min.js"></script>
<!--materialize js-->
<script type="text/javascript" src="asset/js/materialize.min.js"></script>
<!--prism-->
<script type="text/javascript" src="asset/vendors/prism/prism.js"></script>
<!--scrollbar-->
<script type="text/javascript" src="asset/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="asset/js/plugins.js"></script>
<!--custom-script.js - Add your own theme custom JS-->
<script type="text/javascript" src="asset/js/custom-script.js"></script>
<!-- data-tables -->
<script type="text/javascript" src="asset/js/materialize-plugin/data-tables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="asset/js/materialize-plugin/data-tables/data-tables-script.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#data-table-simple').DataTable();
    });

    //jquery datepicker
    $('#tgl_surat, #tgl_masuk, #tgl_buat, #batas_waktu,#dari_tanggal,#sampai_tanggal').pickadate({
        selectMonths: true,
        selectYears: 10,
        format: "dd-mm-yyyy"
    });
    $("#alert-message").alert().delay(3000).slideUp('slow');
</script>
</script>

</body>

</html>