document.querySelectorAll('.rp').forEach(function (input) {
  input.addEventListener('input', function (e) {
    let value = this.value.replace(/\D/g, '');
    value = value.replace(/^0+/, '');
    this.value = value ? 'Rp ' + new Intl.NumberFormat('id-ID').format(value) : '';
  });

  input.addEventListener('keydown', function (e) {
    if (
    e.key === 'Backspace' || e.key === 'Delete' ||
    e.key === 'ArrowLeft' || e.key === 'ArrowRight' ||
    e.ctrlKey || e.metaKey
  ) {
    return;
  }

  // Allow only number keys
  if (!/^[0-9]$/.test(e.key)) {
    e.preventDefault();
  }
  })
});

document.addEventListener("DOMContentLoaded", function () {
  const start = document.getElementById("startMonth");
  const end = document.getElementById("endMonth");

  if (!start || !end) return;

  start.addEventListener("change", function () {
    if (start.value) {
      // Aktifkan input endMonth
      end.disabled = false;
      // Set nilai minimum endMonth
      end.min = start.value;

      // Jika endMonth sekarang nilainya lebih kecil dari startMonth, ubah nilainya
      if (end.value && end.value < start.value) {
        end.value = start.value;
      }
    } else {
      // Kalau user hapus lagi nilai startMonth, disable kembali endMonth
      end.disabled = true;
      end.value = "";
    }
  });
});

// fungsi simpan pajak - global untuk dashboard
// function simpanPajak(kategori, data) {
//   const isLoggedIn = document.body.getAttribute('data-authenticated') === 'true';

//   if (isLoggedIn) {
//       fetch('/import-guest-pajak', {
//           method: 'POST',
//           headers: {
//               'Content-Type': 'application/json',
//               'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
//           },
//           body: JSON.stringify({ kategori, data })
//       })
//       .then(res => res.json())
//       .then(response => {
//           if (response.success) {
//               console.log('Data pajak berhasil disimpan ke server.');
//           }
//       });
//   } else {
//       localStorage.setItem('ezpajak_guest', JSON.stringify({ kategori, data }));
//       console.log('Data pajak disimpan sementara di localStorage (guest).');
//   }
// }

const startMonthInput = document.getElementById('startMonth');
const endMonthInput = document.getElementById('endMonth');
const spdnForm = document.getElementById('spdnForm');

function checkSPDNVisibility() {
  const start = startMonthInput.value;
  const end = endMonthInput.value;

  // Tampilkan form SPDN hanya jika periode bukan dari Januari sampai Desember
  if (start === '2025-01' && end === '2025-12') {
      spdnForm.style.display = 'none';
  } else if (start && end) {
      spdnForm.style.display = 'block';
  }
}

startMonthInput.addEventListener('change', checkSPDNVisibility);
endMonthInput.addEventListener('change', checkSPDNVisibility);

document.addEventListener("DOMContentLoaded", function () {
  const parseRupiah = (str) => parseInt((str || '').replace(/[^\d]/g, '') || '0');

  let isDisetahunkan = false;

  function hitung() {
    // Ambil input
    const bulanAwal = document.getElementById('startMonth').value;
    const bulanAkhir = document.getElementById('endMonth').value;
    const bulanMulai = bulanAwal ? parseInt(bulanAwal.split('-')[1]) : 1;
    const bulanSelesai = bulanAkhir ? parseInt(bulanAkhir.split('-')[1]) : 12;
    const totalBulan = bulanSelesai - bulanMulai + 1;

    const gaji = parseRupiah(document.getElementById('floatingGaji').value);
    const tunjPPh = parseRupiah(document.getElementById('floatingPPh').value);
    const tunjLain = parseRupiah(document.getElementById('floatingLain').value);
    const honor = parseRupiah(document.getElementById('floatingHonor').value);
    const premi = parseRupiah(document.getElementById('floatingPremi').value);
    const natura = parseRupiah(document.getElementById('floatingNatura').value);
    const tantiem = parseRupiah(document.getElementById('floatingTantiem').value);
    const iuranTHT = parseRupiah(document.getElementById('floatingTHT').value);
    const zakat = parseRupiah(document.getElementById('floatingZakar').value);
    const pphTerpotong = parseRupiah(document.getElementById('floatingTerpotong').value);
    const netoMasaSebelum = parseRupiah(document.getElementById('floatingMasaSebelum').value)

    const tanggungan = parseInt(document.getElementById('floatingInput').value || '0');
    const statusKawin = document.getElementById('floatingSelect').value;

    const gender = document.querySelector('input[name="sex"]:checked')?.value;

    // Cek status disetahunkan
    if (bulanMulai === 1 && bulanSelesai === 12) {
      isDisetahunkan = false;
    } else {
      const spdnYa = document.getElementById('spdn-ya');
      const spdnTidak = document.getElementById('spdn-tidak');
      if (spdnYa && spdnYa.checked) {
        isDisetahunkan = false;
      } else if (spdnTidak && spdnTidak.checked) {
        isDisetahunkan = true;
      }
    }

    // Penghasilan Bruto
    const penghasilanBruto = gaji + tunjPPh + tunjLain + honor + premi + natura + tantiem;

    // Biaya Jabatan Maksimal = 5% penghasilan bruto, maks 500.000 x bulan kerja
    const biayaJabatanMax = Math.min(penghasilanBruto * 0.05, 500000 * totalBulan);
    document.getElementById('biayaJabatan').textContent = formatRupiah(biayaJabatanMax)

    const totalPengurangan = biayaJabatanMax + iuranTHT + zakat;
    const penghasilanNeto = penghasilanBruto - totalPengurangan;

    const netoTotal = penghasilanNeto + netoMasaSebelum
    // Disetahunkan atau tidak
    const netoUntukPPh = (isDisetahunkan ? (netoTotal / totalBulan * 12) : netoTotal);

    // Hitung PTKP
    let ptkp = 54000000; // TK/0 default
    const jumlahTanggungan = Math.min(3, tanggungan);

    // 2. Terapkan logika berdasarkan status
    if (statusKawin === 'Kawin') {
        if (gender === 'Pria') {
            // Pria Kawin: dapat tambahan kawin + tanggungan (yang sudah dibatasi)
            ptkp += 4500000; // Tambahan kawin
            ptkp += jumlahTanggungan * 4500000; // Gunakan variabel baru
        }
        // Untuk Wanita Kawin, PTKP tetap 54.000.000.

    } else {
        // 'Tidak Kawin' (Pria atau Wanita): hanya dapat tambahan tanggungan
        ptkp += jumlahTanggungan * 4500000; // Gunakan variabel baru
    }

    const pkp = Math.max(0, netoUntukPPh - ptkp);

    // Hitung PPh 21 dengan tarif progresif
    let pph21Setahun = 0;
    let sisaPKP = pkp;
    const tarif = [0.05, 0.15, 0.25, 0.3, 0.35];
    const batas = [60000000, 250000000, 500000000, 5000000000];

    for (let i = 0; i < batas.length; i++) {
      const lower = i === 0 ? 0 : batas[i - 1];
      const upper = batas[i];
      const lapis = Math.min(sisaPKP, upper - lower);
      if (lapis > 0) {
        pph21Setahun += lapis * tarif[i];
        sisaPKP -= lapis;
      }
    }
    if (sisaPKP > 0) pph21Setahun += sisaPKP * tarif[tarif.length - 1];

    const pph21Fin = isDisetahunkan ? pph21Setahun * totalBulan / 12 : pph21Setahun

    const pph21pkp = Math.max(0, pph21Fin);
    const pph21MasaIni = Math.max(0, pph21Fin - pphTerpotong);

    // Tampilkan hasil
    const res = document.querySelectorAll('.res');
    res[0].textContent = formatRupiah(penghasilanNeto);
    res[1].textContent = formatRupiah(netoUntukPPh);
    res[1].closest('.res-field').querySelector('p.label').textContent = isDisetahunkan ? 'Penghasilan Neto untuk PPh 21 Disetahunkan' : 'Penghasilan Neto untuk PPh 21 Setahun';
    document.getElementById('pkpsetahun').textContent = isDisetahunkan ? 'Penghasilan Kena Pajak Disetahunkan' : 'Penghasilan Kena Pajak Setahun'
    document.getElementById('pphPkpTitle').textContent = isDisetahunkan ? 'PPh Pasal 21 atas PKP Disetahunkan' : 'PPh Pasal 21 atas PKP Setahun'

    const tooltip = res[2].closest('.res-field').querySelector('.tooltip-container');
    if (tooltip) tooltip.style.display = isDisetahunkan ? 'block' : 'none';

    res[2].textContent = formatRupiah(ptkp);
    res[3].textContent = formatRupiah(pkp);
    res[4].textContent = pkp <= 60000000 ? '5%' : '5% - 15%' + (pkp > 250000000 ? ' - 25%' : '');
    res[5].textContent = formatRupiah(pph21pkp)

    const totalRupiah = document.querySelectorAll('.rp-total');
    totalRupiah[0].textContent = formatRupiah(penghasilanBruto);
    totalRupiah[1].textContent = formatRupiah(totalPengurangan);
    totalRupiah[2].textContent = formatRupiah(pph21MasaIni);

    // tambahan
    const hasil = {
    jenis_kelamin: gender,
    tanggungan: tanggungan,
    status_perkawinan: statusKawin,
    masa_awal: bulanAwal + '-01',
    masa_akhir: bulanAkhir + '-01',
    disetahunkan: isDisetahunkan,

    gaji: gaji,
    tunjangan_pph: tunjPPh,
    tunjangan_lain: tunjLain,
    honor: honor,
    premi: premi,
    natura: natura,
    tantiem: tantiem,

    biaya_jabatan: biayaJabatanMax,
    iuran_pensiun: iuranTHT,
    zakat: zakat,

    penghasilan_bruto: penghasilanBruto,
    pengurangan: totalPengurangan,
    penghasilan_neto: penghasilanNeto,
    penghasilan_neto_masa_sebelumnya: netoMasaSebelum,
    penghasilan_neto_pph21: netoUntukPPh,
    ptkp: ptkp,
    pkp: pkp,
    tarif_progresif: res[4].textContent,
    pph21_pkp: pph21pkp,
    pph21_dipotong_masa_sebelum: pphTerpotong,
    pph21_terutang: pph21MasaIni
    };

    console.log("Hasil dihitung: ", hasil)
    // simpanPajak('pegawai_tetap', hasil);

  }

  function formatRupiah(value) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
  }

  document.querySelectorAll('input, select').forEach(input => {
    input.addEventListener('change', hitung);
    input.addEventListener('input', hitung);
  });

    // tambahan supaya hitung otomatis saat halaman pertama kali terbuka
    hitung();
});

function calculateTaxDates() {
    const today = new Date();
    const currentYear = today.getFullYear();

    const akhirTahunPajak = new Date(`${currentYear}-12-31`);
    const jatuhTempo = new Date(`${currentYear + 1}-03-31`);

    function getCountdown(targetDate) {
      const diffMs = targetDate - today;
      if (diffMs < 0) return "Sudah lewat";

      const diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));
      const months = Math.floor(diffDays / 30.44); // Rata-rata hari per bulan
      const weeks = Math.floor((diffDays % 30.44) / 7);
      const days = Math.floor((diffDays % 30.44) % 7);

      let parts = [];
      if (months) parts.push(`${months} Bulan`);
      if (weeks) parts.push(`${weeks} Minggu`);
      if (days) parts.push(`${days} Hari`);
      return parts.join(" ");
    }

    document.getElementById("akhir-tahun").textContent = akhirTahunPajak.toLocaleDateString("id-ID", {
      day: "2-digit", month: "short", year: "numeric"
    });
    document.getElementById("jatuh-tempo").textContent = jatuhTempo.toLocaleDateString("id-ID", {
      day: "2-digit", month: "short", year: "numeric"
    });

    document.getElementById("batas-start").textContent = getCountdown(akhirTahunPajak);
    document.getElementById("batas-end").textContent = getCountdown(jatuhTempo);
  }

calculateTaxDates();

// Letakkan di awal atau di dalam blok event listener DOMContentLoaded
document.addEventListener('DOMContentLoaded', function () {
    // Fungsi baru untuk memuat data dari localStorage saat halaman dimuat
    loadAndRestoreCalculatorData();

    // Fungsi pembantu untuk memformat angka menjadi format Rupiah
    const formatRupiah = (number) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);

    // Fungsi baru untuk mengumpulkan dan menyimpan semua data form
    function saveCalculatorDataToLocalStorage() {
        const parseRupiah = (str) => parseInt((str || '').replace(/[^\d]/g, '') || '0');

        const calculatorData = {
            // Informasi Pegawai
            jenis_kelamin: document.querySelector('input[name="sex"]:checked')?.value,
            tanggungan: document.getElementById('floatingInput').value,
            status_perkawinan: document.getElementById('floatingSelect').value,
            masa_awal: document.getElementById('startMonth').value,
            masa_akhir: document.getElementById('endMonth').value,
            disetahunkan: document.querySelector('input[name="spdn"]:checked')?.value,

            // Penghasilan
            gaji: document.getElementById('floatingGaji').value,
            tunjangan_pph: document.getElementById('floatingPPh').value,
            tunjangan_lain: document.getElementById('floatingLain').value,
            honor: document.getElementById('floatingHonor').value,
            premi: document.getElementById('floatingPremi').value,
            natura: document.getElementById('floatingNatura').value,
            tantiem: document.getElementById('floatingTantiem').value,

            // Pengurangan
            iuran_pensiun: document.getElementById('floatingTHT').value,
            zakat: document.getElementById('floatingZakar').value,
            
            // Input Hasil Kalkulasi
            penghasilan_neto_masa_sebelumnya: document.getElementById('floatingMasaSebelum').value,
            pph21_dipotong_masa_sebelum: document.getElementById('floatingTerpotong').value,

            // Teks Hasil Kalkulasi (untuk ditampilkan kembali)
            penghasilan_bruto_text: document.querySelectorAll('.rp-total')[0].textContent,
            pengurangan_text: document.querySelectorAll('.rp-total')[1].textContent,
            biaya_jabatan_text: document.getElementById('biayaJabatan').textContent,
            penghasilan_neto_text: document.querySelectorAll('.res')[0].textContent,
            penghasilan_neto_pph21_text: document.querySelectorAll('.res')[1].textContent,
            ptkp_text: document.querySelectorAll('.res')[2].textContent,
            pkp_text: document.querySelectorAll('.res')[3].textContent,
            tarif_progresif_text: document.querySelectorAll('.res')[4].textContent,
            pph21_pkp_text: document.querySelectorAll('.res')[5].textContent,
            pph21_terutang_text: document.querySelectorAll('.rp-total')[2].textContent
        };

        // Simpan sebagai string JSON di localStorage
        localStorage.setItem('calculatorFormData', JSON.stringify(calculatorData));
        console.log('Data kalkulator disimpan ke localStorage.');
    }

    // Fungsi baru untuk memuat dan mengisi ulang form
    function loadAndRestoreCalculatorData() {
        const savedDataJSON = localStorage.getItem('calculatorFormData');

        if (savedDataJSON) {
            console.log('Data kalkulator ditemukan, memuat ulang form...');
            const data = JSON.parse(savedDataJSON);

            // Isi kembali field input
            if(data.jenis_kelamin) document.querySelector(`input[name="sex"][value="${data.jenis_kelamin}"]`).checked = true;
            document.getElementById('floatingInput').value = data.tanggungan;
            document.getElementById('floatingSelect').value = data.status_perkawinan;
            document.getElementById('startMonth').value = data.masa_awal;
            document.getElementById('endMonth').value = data.masa_akhir;
            if(data.disetahunkan) document.querySelector(`input[name="spdn"][value="${data.disetahunkan}"]`).checked = true;

            document.getElementById('floatingGaji').value = data.gaji;
            document.getElementById('floatingPPh').value = data.tunjangan_pph;
            document.getElementById('floatingLain').value = data.tunjangan_lain;
            document.getElementById('floatingHonor').value = data.honor;
            document.getElementById('floatingPremi').value = data.premi;
            document.getElementById('floatingNatura').value = data.natura;
            document.getElementById('floatingTantiem').value = data.tantiem;
            
            document.getElementById('floatingTHT').value = data.iuran_pensiun;
            document.getElementById('floatingZakar').value = data.zakat;

            document.getElementById('floatingMasaSebelum').value = data.penghasilan_neto_masa_sebelumnya;
            document.getElementById('floatingTerpotong').value = data.pph21_dipotong_masa_sebelum;

            // Isi kembali field hasil kalkulasi
            document.querySelectorAll('.rp-total')[0].textContent = data.penghasilan_bruto_text;
            document.querySelectorAll('.rp-total')[1].textContent = data.pengurangan_text;
            document.getElementById('biayaJabatan').textContent = data.biaya_jabatan_text;
            document.querySelectorAll('.res')[0].textContent = data.penghasilan_neto_text;
            document.querySelectorAll('.res')[1].textContent = data.penghasilan_neto_pph21_text;
            document.querySelectorAll('.res')[2].textContent = data.ptkp_text;
            document.querySelectorAll('.res')[3].textContent = data.pkp_text;
            document.querySelectorAll('.res')[4].textContent = data.tarif_progresif_text;
            document.querySelectorAll('.res')[5].textContent = data.pph21_pkp_text;
            document.querySelectorAll('.rp-total')[2].textContent = data.pph21_terutang_text;

            // Penting: Hapus data dari localStorage setelah digunakan
            localStorage.removeItem('calculatorFormData');
            console.log('Data dari localStorage telah dimuat dan dihapus.');
            
            // Penting: Panggil fungsi kalkulasi utama Anda di sini jika ada,
            // atau picu event pada salah satu input untuk menjalankan ulang kalkulasi.
            // Ini untuk memastikan semua field ter-update jika ada logika tersembunyi.
            document.getElementById('floatingGaji').dispatchEvent(new Event('input', { bubbles: true }));
        }
    }


    // --- MODIFIKASI EVENT LISTENER ---

      document.getElementById('pay-now').addEventListener('click', async function () {
    const isLoggedIn = document.body.getAttribute('data-authenticated') === 'true';

    if (!isLoggedIn) {
      saveCalculatorDataToLocalStorage()
        // Ambil URL halaman kalkulator saat ini
        const redirectUrl = window.location.pathname; // Hasilnya akan seperti "/halaman-kalkulator"

        // Arahkan ke halaman login DENGAN menyertakan URL tujuan
        // Ini akan menghasilkan URL seperti: /login?redirect_to=/halaman-kalkulator
        window.location.href = '/login?redirect_to=' + redirectUrl;
        
        return; // Hentikan eksekusi skrip
    }
      const parseRupiah = (str) => parseInt((str || '').replace(/[^\d]/g, '') || '0');

      const data = {
          jenis_kelamin: document.querySelector('input[name="sex"]:checked')?.value,
          tanggungan: document.getElementById('floatingInput').value,
          status_perkawinan: document.getElementById('floatingSelect').value,
          masa_awal: document.getElementById('startMonth').value + '-01',
          masa_akhir: document.getElementById('endMonth').value + '-01',
          disetahunkan: document.getElementById('spdn-tidak')?.checked ?? false,

          gaji: parseRupiah(document.getElementById('floatingGaji').value),
          tunjangan_pph: parseRupiah(document.getElementById('floatingPPh').value),
          tunjangan_lain: parseRupiah(document.getElementById('floatingLain').value),
          honor: parseRupiah(document.getElementById('floatingHonor').value),
          premi: parseRupiah(document.getElementById('floatingPremi').value),
          natura: parseRupiah(document.getElementById('floatingNatura').value),
          tantiem: parseRupiah(document.getElementById('floatingTantiem').value),

          biaya_jabatan: parseRupiah(document.getElementById('biayaJabatan').textContent),
          iuran_pensiun: parseRupiah(document.getElementById('floatingTHT').value),
          zakat: parseRupiah(document.getElementById('floatingZakar').value),

          penghasilan_bruto: parseRupiah(document.querySelectorAll('.rp-total')[0].textContent),
          pengurangan: parseRupiah(document.querySelectorAll('.rp-total')[1].textContent),
          penghasilan_neto: parseRupiah(document.querySelectorAll('.res')[0].textContent),
          penghasilan_neto_masa_sebelumnya: parseRupiah(document.getElementById('floatingMasaSebelum').value),
          penghasilan_neto_pph21: parseRupiah(document.querySelectorAll('.res')[1].textContent),
          ptkp: parseRupiah(document.querySelectorAll('.res')[2].textContent),
          pkp: parseRupiah(document.querySelectorAll('.res')[3].textContent),
          tarif_progresif: document.querySelectorAll('.res')[4].textContent,
          pph21_pkp: parseRupiah(document.querySelectorAll('.res')[5].textContent),
          pph21_dipotong_masa_sebelum: parseRupiah(document.getElementById('floatingTerpotong').value),
          pph21_terutang: parseRupiah(document.querySelectorAll('.rp-total')[2].textContent)
      };

      fetch('/pegawai-tetap/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(async response => {
            if (!response.ok) {
                if (response.status === 422) {
                    return response.json().then(error => {
                      window.scrollTo({ top: 0, behavior: 'smooth' });
                        // Bersihkan semua error dulu
                        document.querySelectorAll('[id^="error-"]').forEach(el => el.textContent = '');

                        // Tampilkan error dari Laravel
                        for (let field in error.errors) {
                            const target = document.getElementById(`error-${field}`);
                            if (target) {
                                target.textContent = error.errors[field][0];
                            }
                        }
                    });
                } else {
                    console.error('Unexpected error:', response.status);
                }
            } else {
                return response.json().then(data => {
                    // Cek jika server mengembalikan 'success: true' dan 'user_id'
                    if (data.success && data.user_id) {
                        console.log('Data berhasil disimpan! Mengarahkan ke pembayaran...');
                        
                        // Arahkan pengguna ke halaman pembayaran dengan ID yang diterima
                        console.log(data.user_id)
                        window.location.href = '/payment/paypage/' + data.user_id;
                    
                    } else {
                        // Jika sukses tapi tidak ada ID, tampilkan error
                        alert('Terjadi kesalahan: Gagal mendapatkan ID perhitungan.');
                        // Aktifkan kembali tombol jika perlu
                    }
                });
            }
        })
        .catch(err => {
            console.error('Network error:', err);
        });
  });

  document.getElementById('remind-later').addEventListener('click', async function () {
    const isLoggedIn = document.body.getAttribute('data-authenticated') === 'true';

      if (!isLoggedIn) {
        saveCalculatorDataToLocalStorage()
          // Simpan URL saat ini ke sessionStorage
          sessionStorage.setItem('redirect_after_login', window.location.pathname);
          // Redirect ke halaman login
          window.location.href = '/login';
          return;
      }
      const parseRupiah = (str) => parseInt((str || '').replace(/[^\d]/g, '') || '0');

      const data = {
          jenis_kelamin: document.querySelector('input[name="sex"]:checked')?.value,
          tanggungan: document.getElementById('floatingInput').value,
          status_perkawinan: document.getElementById('floatingSelect').value,
          masa_awal: document.getElementById('startMonth').value + '-01',
          masa_akhir: document.getElementById('endMonth').value + '-01',
          disetahunkan: document.getElementById('spdn-tidak')?.checked ?? false,

          gaji: parseRupiah(document.getElementById('floatingGaji').value),
          tunjangan_pph: parseRupiah(document.getElementById('floatingPPh').value),
          tunjangan_lain: parseRupiah(document.getElementById('floatingLain').value),
          honor: parseRupiah(document.getElementById('floatingHonor').value),
          premi: parseRupiah(document.getElementById('floatingPremi').value),
          natura: parseRupiah(document.getElementById('floatingNatura').value),
          tantiem: parseRupiah(document.getElementById('floatingTantiem').value),

          biaya_jabatan: parseRupiah(document.getElementById('biayaJabatan').textContent),
          iuran_pensiun: parseRupiah(document.getElementById('floatingTHT').value),
          zakat: parseRupiah(document.getElementById('floatingZakar').value),

          penghasilan_bruto: parseRupiah(document.querySelectorAll('.rp-total')[0].textContent),
          pengurangan: parseRupiah(document.querySelectorAll('.rp-total')[1].textContent),
          penghasilan_neto: parseRupiah(document.querySelectorAll('.res')[0].textContent),
          penghasilan_neto_masa_sebelumnya: parseRupiah(document.getElementById('floatingMasaSebelum').value),
          penghasilan_neto_pph21: parseRupiah(document.querySelectorAll('.res')[1].textContent),
          ptkp: parseRupiah(document.querySelectorAll('.res')[2].textContent),
          pkp: parseRupiah(document.querySelectorAll('.res')[3].textContent),
          tarif_progresif: document.querySelectorAll('.res')[4].textContent,
          pph21_pkp: parseRupiah(document.querySelectorAll('.res')[5].textContent),
          pph21_dipotong_masa_sebelum: parseRupiah(document.getElementById('floatingTerpotong').value),
          pph21_terutang: parseRupiah(document.querySelectorAll('.rp-total')[2].textContent)
      };

      // const currentPath = window.location.pathname;
      // window.location.href = `/login?redirect=${encodeURIComponent(currentPath)}`;

        fetch('/pegawai-tetap/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                if (response.status === 422) {
                    return response.json().then(error => {
                      window.scrollTo({ top: 0, behavior: 'smooth' });
                        // Bersihkan semua error dulu
                        document.querySelectorAll('[id^="error-"]').forEach(el => el.textContent = '');

                        // Tampilkan error dari Laravel
                        for (let field in error.errors) {
                            const target = document.getElementById(`error-${field}`);
                            if (target) {
                                target.textContent = error.errors[field][0];
                            }
                        }
                    });
                } else {
                    console.error('Unexpected error:', response.status);
                }
              } else {
                return response.json().then(data => {
                    // Cek jika server mengembalikan 'success: true' dan 'user_id'
                    if (data.success && data.user_id) {
                        console.log('Data berhasil disimpan! Mengarahkan ke pembayaran...');
                        
                        // Arahkan pengguna ke halaman pembayaran dengan ID yang diterima
                        console.log(data.user_id)
                        window.location.href = '/home';
                    
                    } else {
                        // Jika sukses tapi tidak ada ID, tampilkan error
                        alert('Terjadi kesalahan: Gagal mendapatkan ID perhitungan.');
                        // Aktifkan kembali tombol jika perlu
                    }
                });
            }
        })
        .catch(err => {
            console.error('Network error:', err);
        });

  });

});


