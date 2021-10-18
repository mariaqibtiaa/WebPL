<noscript>
    <meta http-equiv="refresh" content="0;URL='./enable-javascript.html'" />
</noscript>

<!-- Footer START -->
<footer class="page-footer">
    <div class="container">
        <div class="row">
            <br />
        </div>
    </div>
    <div class="footer-copyright #b71c1c red darken-4 white-text">
        <div class="container" id="footer">
            <?php
            $query = mysqli_query($config, "SELECT * FROM tbl_instansi");
            while ($data = mysqli_fetch_array($query)) {
            ?>
                <span class="white-text">&copy; <?php echo date("Y"); ?>
                    <?php
                    if (!empty($data['nama'])) {
                        echo $data['nama'];
                    } else {
                        echo 'PT. Dagsap Endura Eatore';
                    }
                    ?>
                    </a>
                </span>
                <div class="right hide-on-small-only">
                <?php
            }
                ?>
                </div>
        </div>
    </div>
</footer>
<!-- Footer END -->

<!-- Javascript START -->
<script type="text/javascript" src="asset/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="asset/js/materialize.min.js"></script>
<script type="text/javascript" src="asset/js/jquery-ui.min.js"></script>
<script data-pace-options='{ "ajax": false }' src='asset/js/pace.min.js'></script>
<script type="text/javascript">
    //jquery dropdown
    $(".dropdown-button").dropdown({
        hover: false
    });

    //jquery sidenav on mobile
    $('.button-collapse').sideNav({
        menuWidth: 240,
        edge: 'left',
        closeOnClick: true
    });

    //jquery datepicker
    $('#tgl_surat, #tgl_masuk, #batas_waktu,#dari_tanggal,#sampai_tanggal').pickadate({
        selectMonths: true,
        selectYears: 10,
        format: "yyyy-mm-dd"
    });

    //jquery teaxtarea
    $('#isi_ringkas').val('');
    $('#isi_ringkas').trigger('autoresize');

    //jquery dropdown select dan tooltip
    $(document).ready(function() {
        $('select').material_select();
        $('.tooltipped').tooltip({
            delay: 10
        });
    });

    //jquery autocomplete
    $(function() {
        $("#kode").autocomplete({
            source: 'kode.php'
        });
    });

    //jquery untuk menampilkan pemberitahuan
    $("#alert-message").alert().delay(5000).fadeOut('slow');

    //jquery modal
    $(document).ready(function() {
        $('.modal-trigger').leanModal();
    });
</script>
<!-- Javascript END -->