<!DOCTYPE html>
<html>

<head>
    <title>Kalkulator Akutansi</title>

    <!-- Pengaturan CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">

</head>

<body>
    <!-- Pengaturan Navbar -->
    <?php
        include "navbar.php";
    ?>
    <!-- Pengaturan Menu -->
    <div class="container-fluid">
        <div class="row">
            <?php
              include "sidebar.php";
            ?>
            <!-- Pengaturan Kontent -->
            <main class="col-sm-9 ml-sm-auto col-md-10 pt-3" role="main">

                <div class="card">
                    <div class="card-header">
                        Kalkulator Akutansi
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">Metode Floating Rate</h6>
                        <p class="card-text"></p>
                        <!-- Modal Boostrap -->
                        <!-- Modal -->
                        <div id="app">
                            <div id="form-pemasukan">
                                <p>Jumlah Pinjaman:
                                    <input v-model="pokokPinjaman" class="form-control">
                                </p>

                                <p>Lama Angsuran/Tahun:
                                    <input v-model="lamaTahun" @change="kreditBerubah" type="number"
                                        class="form-control">
                                </p>

                                <!-- input lama peminjaman dalam kredit pertahun -->

                                <div id="sukubunga" v-if="lamaTahun > 0">
                                    <div v-for="(item, i) in listKredit">
                                        Bunga tahun ke-{{i + 1}}
                                        <input class="form-control" v-model="listKredit[i].v">
                                    </div>
                                </div>

                                <br><br>

                                <button class="btn btn-primary" @click="cariFloating">Proses</button>
                            </div>
                            <br><br>
                            <div id="tabelAngsuran" v-if="jawabanFloating">
                                <h3>Tabel Perhitungan</h3>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Bulan</th>
                                            <th>Bunga/th</th>
                                            <th>Angsuran Bunga</th>
                                            <th>Angsuran Pokok</th>
                                            <th>Total Angsuran</th>
                                            <th>Sisa Pinjaman</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>{{ pokokPinjaman | keRupiah }}</td>
                                        </tr>
                                        <tr v-for="(sisaPinjam, i) in storeSisaPinjaman">
                                            <td>{{ i + 1 }}</td>
                                            <td>{{ storeKreditan[i] | kePersen}}</td>
                                            <td>{{ storeAngsuranBunga[i] | keRupiah }}</td>
                                            <td>{{ storeAngsuranPokok[i] | keRupiah }}</td>
                                            <td>{{ storeTotalAngsuran[i] | keRupiah }}</td>
                                            <td>{{ sisaPinjam | keRupiah }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td>Total</td>
                                            <td>{{ totalStore(storeAngsuranBunga) | keRupiah }}</td>
                                            <td>{{ totalStore(storeAngsuranPokok) | keRupiah }}</td>
                                            <td>{{ totalStore(storeTotalAngsuran) | keRupiah }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>

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

        <script src="js/vue.js "></script>
        <script src="js/math.js "></script>
        <script src="js/floating.js "></script>

</body>

</html>