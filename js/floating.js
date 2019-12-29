Vue.filter('keRupiah', function convertToRupiah(angka) {
  var rupiah = '';
  var angkarev = angka.toString().split('').reverse().join('');
  for (var i = 0; i < angkarev.length; i++) if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';
  return 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
})

Vue.filter('keBulan', function keBulan(bulan) {
  return bulan + ' bulan'
})

Vue.filter('kePersen', function kePersen(persen) {
  return persen + '%';
})

Vue.filter('bulatkan', function (desimal) {
  return math.round(desimal, 0);
})

var app = new Vue({
  el: "#app",
  data: {
    jawabanFloating: false,
    pokokPinjaman: 12000000,        // rupiah
    sukuBungaPerTahun: 12,          // persen
    lamaKreditDalamBulan: 12,      //bulan

    angsuranBulanan: 0,



    storeSisaPinjaman: [],
    storeAngsuranBunga: [],
    storeAngsuranPokok: [],
    storeTotalAngsuran: [],
    storeKreditan: [],

    lamaTahun: 0, //tahun,
    listKredit: [{ v: 0 }],



  },
  methods: {
    // 

    kreditBerubah() {

      let tempSimpan = []
      lamaTahun = this.lamaTahun;
      while (lamaTahun > 0) {
        tempSimpan.push({ v: 0 });
        lamaTahun--;
      }
      this.listKredit.splice(0);
      this.listKredit.push(...tempSimpan);

      this.lamaKreditDalamBulan = this.lamaKreditDalamBulan * this.lamaTahun;
    },


    cariFloating() {
      console.log(this.listKredit[0].v)
      const rubahPersenKeDesimal = persen => persen / 100;

      const rumusAngsuranBulanan = (pokokPinjaman, sukuBungaPerTahun, lamaKreditDalamBulan) => {
        sukuBungaPerTahun = rubahPersenKeDesimal(sukuBungaPerTahun);

        return (pokokPinjaman * (sukuBungaPerTahun / 12)) / (1 - 1 / math.pow((1 + sukuBungaPerTahun / 12), lamaKreditDalamBulan))
      }

      const rumusAngsuranBunga = (saldoTerakhir, sukuBungaPerTahun) => {
        sukuBungaPerTahun = rubahPersenKeDesimal(sukuBungaPerTahun);
        return saldoTerakhir * sukuBungaPerTahun / 12;
      }

      const rumusAngsuranPokok = (angsuranTotal, angsuranBunga) => angsuranTotal - angsuranBunga;

      const totalAngsuran = (angsuranBunga, angsuranPokok) => angsuranBunga + angsuranPokok;

      this.angsuranBulanan = rumusAngsuranBulanan(this.pokokPinjaman, this.listKredit[0].v, this.lamaKreditDalamBulan);


      // cari isi pinjaman
      let storeSisaPinjaman = [];
      let storeAngsuranPokok = [];
      let storeAngsuranBunga = [];
      let storeTotalAngsuran = [];
      let storeKreditan = [];



      let nilaiSaldoTerakhir = this.pokokPinjaman;



      let nilaiAngsuranBunga = 0;
      let nilaiAngsuranPokok = 0;
      let nilaiTotalAngsuran = 0;


      //tracking bunga
      let trackingIndexNomor = 0;
      let indexBunga = 0;
      let bunga = this.listKredit[indexBunga].v

      var isKondisi = nilaiSaldoTerakhir > 0 ? true : false;

      while (isKondisi) {
        if (nilaiSaldoTerakhir < 0) break;

        if (!(trackingIndexNomor % 12) && trackingIndexNomor > 0) {
          indexBunga++;
          bunga = this.listKredit[indexBunga].v
          console.log(indexBunga)
        }
        trackingIndexNomor++;

        console.log(bunga);

        nilaiTotalAngsuran = math.round(rumusAngsuranBulanan(this.pokokPinjaman, bunga, this.lamaKreditDalamBulan));
        nilaiAngsuranBunga = math.round(rumusAngsuranBunga(nilaiSaldoTerakhir, bunga));
        nilaiAngsuranPokok = math.round(rumusAngsuranPokok(nilaiTotalAngsuran, nilaiAngsuranBunga));



        nilaiSaldoTerakhir = math.round(nilaiSaldoTerakhir - nilaiAngsuranPokok);
        if (nilaiSaldoTerakhir < 0) break;
        storeSisaPinjaman.push(nilaiSaldoTerakhir);
        storeAngsuranPokok.push(nilaiAngsuranPokok);
        storeAngsuranBunga.push(nilaiAngsuranBunga);
        storeTotalAngsuran.push(nilaiTotalAngsuran);
        storeKreditan.push(bunga);

      }

      this.storeAngsuranBunga.splice(0);
      this.storeAngsuranPokok.splice(0);
      this.storeSisaPinjaman.splice(0);
      this.storeTotalAngsuran.splice(0);
      this.storeKreditan.splice(0);

      this.storeAngsuranBunga.push(...storeAngsuranBunga);
      this.storeAngsuranPokok.push(...storeAngsuranPokok);
      this.storeSisaPinjaman.push(...storeSisaPinjaman);
      this.storeTotalAngsuran.push(...storeTotalAngsuran);
      this.storeKreditan.push(...storeKreditan);


      this.jawabanFloating = true;

    },

    totalStore(store) {
      return store.reduce((a, b) => a + b, 0);
    }
  },


})

