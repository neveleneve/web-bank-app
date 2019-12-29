<!DOCTYPE html>
<html>

<head>
    <title>Kalkulator Akutansi</title>

    <!-- Pengaturan CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">

</head>

<body>
    <?php
 include "finance.php";
 
 if(isset($_POST['submit']))
 {
    if(empty($_POST['sp']) || empty($_POST['lama_angsuran']) || empty($_POST['flat']) || empty($_POST['sliding']))
    {
        header('Location: http://localhost/projectsip/flat.php');
    }
    else
    {
        $SP_FLAT               = $_POST['sp'];
        $SP_SLIDING            = $_POST['sp'];
        $LA                    = $_POST['lama_angsuran'];
        $I_FLAT                = $_POST['flat'];
        $I_SLIDING             = $_POST['sliding'];
 
        $bunga_flat            = 0;
        $total_bunga_flat      = 0;
        $cicilan_flat          = 0;
        $total_cicilan_flat    = 0;
 
        $bunga_sliding         = 0;
        $total_bunga_sliding   = 0;
        $cicilan_sliding       = 0;
        $total_cicilan_sliding = 0;
 
        $c_pokok               = $_POST['sp'] / $LA;
 
        echo "<h4>Tabel Perhitungan</h4>";
        echo "<table class='table table-striped' width='400px'>";
        echo "<tr>";
            echo "<th rowspan=2>Bulan</th>";
            echo "<th rowspan=2>Sisa Pinjaman</th>";
            echo "<th rowspan=2>Pokok Pinjaman</th>";
            echo "<th colspan=2>Flat Rate</th>";
            echo "<th colspan=2>Sliding Rate</th>";
        echo "</tr>";
        echo "<tr>";
                echo "<th>Bunga ".$I_FLAT." %</th>";
                echo "<th>Total Angsuran</th>";
                echo "<th>Bunga ".$I_SLIDING." %</th>";
                echo "<th>Total Angsuran</th>";
        echo "</tr>";
 
        for($x = 0; $x <= $LA; $x++)
        {
            echo "<tr>";
                echo "<td>".$x."</td>";
 
                // Sisa Pinjaman
                echo "<td>";
                if($x == 0)
                {
                    echo to_rupiah($SP_FLAT);
                }
                else
                {
                    echo to_rupiah($SP_FLAT -= $c_pokok);
                }
                echo "</td>";
 
                // Cicilan Pokok
                echo "<td>";
                if($x == 0)
                {
                    echo 0;
                }
                else
                {
                    echo to_rupiah($c_pokok);
                }
                echo "</td>";
 
                // Bunga Flat Rate
                echo "<td>";
                if($x == 0)
                {
                    echo 0;
                }
                else
                {
                    $bunga_flat = $_POST['sp'] * $I_FLAT / 100 * 30 / 360;
                    echo to_rupiah($bunga_flat);
                }
                echo "</td>";
 
                //// Total Cicilan Flat Rate
                echo "<td>";
                if($x == 0)
                {
                    echo 0;
                }
                else
                {
                    $total_cicilan_flat = $bunga_flat + $c_pokok;
                    echo to_rupiah($total_cicilan_flat);
                }
                echo "</td>";
 
                // Bunga Sliding Rate
                echo "<td>";
                if($x == 0)
                {
                    echo 0;
                }
                else
                {
                    $bunga_sliding = $SP_SLIDING * $I_SLIDING / 100 * 30 / 360;
                    echo to_rupiah($bunga_sliding);
                    $SP_SLIDING -= $c_pokok;
                }
                echo "</td>";
 
                //// Total Cicilan Sliding Rate
                echo "<td>";
                if($x == 0)
                {
                    echo 0;
                }
                else
                {
                    $cicilan_sliding = $c_pokok + $bunga_sliding;
                    echo to_rupiah($cicilan_sliding);
                }
                echo "</td>";
 
            echo "</tr>";
 
            $total_bunga_flat += $bunga_flat;
            $total_cicilan_flat += $cicilan_flat;
            $total_bunga_sliding += $bunga_sliding;
            $total_cicilan_sliding += $cicilan_sliding;
        }
            echo "<tr>";
                echo "<th class='th' colspan=2>Total</th>";
                echo "<th class='th'>".to_rupiah($_POST['sp'])."</th>";
 
                echo "<th class='th'>".to_rupiah($total_bunga_flat)."</th>";
                echo "<th>".to_rupiah($_POST['sp'] + $total_bunga_flat)."</th>";
 
                echo "<th class='th'>".to_rupiah($total_bunga_sliding)."</th>";
                echo "<th class='th'>".to_rupiah($total_cicilan_sliding)."</th>";
 
            echo "</tr>";
        echo "</table>";
    }
 }
 else
 {
 ?>
    <!-- Pengaturan Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="images/LOGO-UR-TERBARU.png" width="30" height="30" class="d-inline-block align-top" alt="">
            Sistem Informasi Perbankan
        </a>
        </div>
        </div>
    </nav>


    <!-- Pengaturan Menu -->
    <div class="container-fluid">
        <div class="row">
        <?php
          include "sidebar.php";
        ?>

            <!-- Pengaturan Kontent -->
            <main class="col-sm-8 col-md-9" role="main">

                <div class="card">
                    <div class="card-header">
                        Kalkulator Akutansi
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">Metode Flat Rate dan Sliding Rate</h6>
                        <p class="card-text"></p>


                        <!-- Modal Boostrap -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Inputkan Data
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Metode Flat Rate dan Sliding Rate
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                                            <fieldset class="form-group">
                                                <label for="formGroupExampleInput">Jumlah Pinjaman</label>
                                                <input type="text" class="form-control" name="sp">
                                            </fieldset>

                                            <fieldset class="form-group">
                                                <label for="formGroupExampleInput2">Jangka Waktu</label>
                                                <input type="text" name="lama_angsuran" class="form-control">
                                            </fieldset>

                                            <fieldset class="form-group">
                                                <label for="formGroupExampleInput2">Bunga/Tahun Flat Rate</label>
                                                <input type="text" name="flat" class="form-control">
                                            </fieldset>

                                            <fieldset class="form-group">
                                                <label for="formGroupExampleInput2">Bunga/Tahun Sliding Rate</label>
                                                <input type="text" name="sliding" class="form-control">
                                            </fieldset>


                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" name="submit"
                                                    class="btn btn-primary">Proses</button>
                                            </div>

                                        </form>
                                        <?php
 }
 ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br>




                    </div>
                    <div class="card-footer text-muted">
                        Copyright <i class="fa fa-copyright" aria-hidden="true"></i> Sistem Informasi Universitas Riau
                        2017
                    </div>
                </div>

        </div>
        </main>











        <!-- Pengaturan Load Javascript -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
            integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous">
        </script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
            integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous">
        </script>

</body>

</html>