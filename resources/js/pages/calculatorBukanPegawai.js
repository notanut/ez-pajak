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


const yaRadio = document.getElementById('dibayar-ya');
const tidakRadio = document.getElementById('dibayar-tidak');
const yaBulanan = document.getElementById('bulanan')
const tidakBulanan = document.getElementById('tidakBulanan')
const samaBulan = document.getElementById('sama')
const bedaBulan = document.getElementById('tidakSama')

const tiapSama = document.getElementById('tiapBulanSama')
const tiapBeda = document.getElementById('tiapBulanBeda')

const wrapBSama = document.getElementById('bulanan-sama-wrap')
const wrapBBeda = document.getElementById('bulanan-beda-wrap')
const wrapTBulan = document.getElementById('tidak-bulanan-wrap')

yaRadio.addEventListener('change', function () {
  if (yaRadio.checked) {
    yaBulanan.style.display = 'block'
    tidakBulanan.style.display = 'none'

    if (samaBulan.checked) {
      tiapSama.style.display = 'block'
      tiapBeda.style.display = 'none'

      wrapBSama.style.display = 'block'
      wrapBBeda.style.display = 'none'
      wrapTBulan.style.display = 'none'
    }
    samaBulan.addEventListener('change', function () {
      if (samaBulan.checked) {
        tiapSama.style.display = 'block'
        tiapBeda.style.display = 'none'
  
        wrapBSama.style.display = 'block'
        wrapBBeda.style.display = 'none'
        wrapTBulan.style.display = 'none'
      }
    })

    if (bedaBulan.checked) {
      tiapBeda.style.display = 'block'
      tiapSama.style.display = 'none'

      wrapBSama.style.display = 'none'
      wrapBBeda.style.display = 'block'
      wrapTBulan.style.display = 'none'
    }
    bedaBulan.addEventListener('change', function () {
      if (bedaBulan.checked) {
        tiapBeda.style.display = 'block'
        tiapSama.style.display = 'none'
  
        wrapBSama.style.display = 'none'
        wrapBBeda.style.display = 'block'
        wrapTBulan.style.display = 'none'
      }
    })
  }
});

tidakRadio.addEventListener('change', function () {
    if (tidakRadio.checked) {
      yaBulanan.style.display = 'none'
      tidakBulanan.style.display = 'block'

      wrapBSama.style.display = 'none'
      wrapBBeda.style.display = 'none'
      wrapTBulan.style.display = 'block'
    }
});

const bayarYa = document.getElementById('ketiga-ya')
const bayarTidak = document.getElementById('ketiga-tidak')
const pihakYa = document.getElementById('yaPihak')

bayarYa.addEventListener('change', function () {
    if (bayarYa.checked) {
        pihakYa.style.display = 'block'
    } 
})

bayarTidak.addEventListener('change', function () {
    if (bayarTidak.checked) {
        pihakYa.style.display = 'none'
    }
})

document.addEventListener("DOMContentLoaded", function () {
  const parseRupiah = (str) => parseInt((str || '').replace(/[^\d]/g, '') || '0');
  const formatRupiah = (value) => 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.floor(value || 0));

  const monthNames = [
    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
  ];

  const tarifPasal17 = [
    { batas: 60000000, tarif: 0.05 },
    { batas: 250000000, tarif: 0.15 },
    { batas: 500000000, tarif: 0.25 },
    { batas: 5000000000, tarif: 0.3 },
    { batas: Infinity, tarif: 0.35 },
  ];

  const hitungTarif = (nilai) => {
    let sisa = nilai;
    let pajak = 0;
    let tarifUsed = new Set();
    for (const { batas, tarif } of tarifPasal17) {
      const ambil = Math.min(sisa, batas);
      if (ambil > 0) {
        pajak += ambil * tarif;
        tarifUsed.add(tarif);
        sisa -= ambil;
        if (sisa <= 0) break;
      }
    }
    return { pajak, tarifUsed };
  };

  function hitung() {
    const isBulanan = document.getElementById('dibayar-ya').checked;
    const isSama = document.getElementById('sama').checked;
    const isBeda = document.getElementById('tidakSama').checked;

    const wrapBSama = document.getElementById('bulanan-sama-wrap');
    const wrapBBeda = document.getElementById('bulanan-beda-wrap');
    const wrapTBulan = document.getElementById('tidak-bulanan-wrap');

    let total = 0;
    let pajakTotal = 0;
    let tarifUsedGlobal = new Set();

    const tarifField = wrapBSama.querySelector('p.res');
    const tarifFieldTidak = wrapTBulan.querySelectorAll('p.res')[2];

    const updateTarifText = (setTarif, element) => {
      const unique = [...setTarif].sort((a, b) => a - b).map(v => `${v * 100}%`);
      element.textContent = unique.join(' - ') || '-';
    };

    if (isBulanan && isSama) {
      const bruto = parseRupiah(document.getElementById('floatingGaji').value);
      const bulan = parseInt(document.getElementById('floatingInput').value || '0');
      const netoPerBulan = bruto * 0.5;
      const { pajak, tarifUsed } = hitungTarif(netoPerBulan);
      pajakTotal = pajak * bulan;
      total = bruto * bulan;
      wrapBSama.querySelector('#metodeHitungSama').textContent = 'Penghasilan Bruto x 50% x Tarif Pasal 17';
      wrapBSama.querySelector('#pphRataSama').textContent = formatRupiah(pajak);
      updateTarifText(tarifUsed, tarifField);
    } else if (isBulanan && isBeda) {
      const wrap = document.getElementById('bulanan-beda-wrap');
      wrap.querySelector('#metodeHitungBeda').textContent = 'Penghasilan Bruto x 50% x Tarif Pasal 17';
      const oldFields = wrap.querySelectorAll('.bulanPajak');
      oldFields.forEach(field => field.remove());

      monthNames.forEach((bulan) => {
        const el = document.getElementById(bulan);
        if (!el) return;
        const bruto = parseRupiah(el.value || '0');
        if (bruto <= 0) return;
        const neto = bruto * 0.5;
        const { pajak, tarifUsed } = hitungTarif(neto);
        pajakTotal += pajak;
        total += bruto;
        tarifUsed.forEach(t => tarifUsedGlobal.add(t));

        const div = document.createElement('div');
        div.classList.add('res-field', 'bulanPajak');
        const key = bulan.toLowerCase().slice(0, 3); // contoh: januari => jan
        div.innerHTML = `<p class="label">${bulan}</p><p id="pajak-${key}" class="res pphBulan">${formatRupiah(pajak)}</p>`;

        wrap.appendChild(div);
      });
      updateTarifText(tarifUsedGlobal, tarifField);
    } else {
      const bruto = parseRupiah(document.getElementById('floatingTerpotong').value);
      let biaya = 0;
      if (document.getElementById('ketiga-ya').checked) {
        biaya = parseRupiah(document.getElementById('floatingPihakKetiga').value);
      }
      const neto = bruto - biaya;
      wrapTBulan.querySelectorAll('p.res')[0].textContent = formatRupiah(neto);
      wrapTBulan.querySelectorAll('p.res')[1].textContent = 'Penghasilan Bruto x 50% x Tarif Pasal 17';
      const { pajak, tarifUsed } = hitungTarif(neto * 0.5);
      pajakTotal = pajak;
      updateTarifText(tarifUsed, tarifFieldTidak);
    }

    document.querySelector('.rp-total').textContent = formatRupiah(pajakTotal);
  }

  document.querySelectorAll('input, select').forEach(el => {
    el.addEventListener('input', hitung);
    el.addEventListener('change', hitung);
  });

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

document.addEventListener('DOMContentLoaded', function () {
    // Definisikan bulan untuk mempermudah
    const bulanList = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    // =================================================================================
    // FUNGSI UNTUK MENYIMPAN DAN MEMUAT DATA DARI LOCALSTORAGE
    // =================================================================================

    function saveBukanPegawaiDataToLocalStorage() {
        console.log('User tidak login, menyimpan data "Bukan Pegawai" ke localStorage...');
        
        const calculatorData = {
            // Pilihan utama
            dibayar_bulanan_value: document.querySelector('input[name="dibayar_bulanan"]:checked')?.value,
            pihak_ketiga_value: document.querySelector('input[name="pihak_ketiga"]:checked')?.value,
            bulanan_sama_value: document.querySelector('input[name="bin"]:checked')?.value,

            // Input: Tidak Bulanan
            total_bruto_tidak_bulanan: document.getElementById('floatingTerpotong').value,
            biaya_pihak_ketiga: document.getElementById('floatingPihakKetiga').value,

            // Input: Bulanan Sama
            bruto_bulanan_sama: document.getElementById('floatingGaji').value,
            jumlah_bulan_bekerja: document.getElementById('floatingInput').value,

            // Input: Bulanan Beda
            bruto_bulanan_beda: {},

            // Hasil: Tidak Bulanan
            netoTidakBulanan_text: document.getElementById('netoTidakBulanan').textContent,
            metodeHitungTidakBulanan_text: document.querySelector('#tidak-bulanan-wrap .res-field:nth-of-type(2) .res').textContent,
            tarifTidakBulanan_text: document.querySelector('#tidak-bulanan-wrap .res-field:nth-of-type(3) .res').textContent,

            // Hasil: Bulanan Sama
            metodeHitungSama_text: document.getElementById('metodeHitungSama').textContent,
            tarifSama_text: document.querySelector('#bulanan-sama-wrap .res-field:nth-of-type(2) .res').textContent,
            pphRataSama_text: document.getElementById('pphRataSama').textContent,

            // Hasil: Bulanan Beda
            metodeHitungBeda_text: document.getElementById('metodeHitungBeda').textContent,

            // Hasil: Grand Total
            pph21_terutang_text: document.querySelector('.total.grand .rp-total').textContent,
        };

        bulanList.forEach(bulan => {
            const inputElement = document.getElementById(bulan);
            if (inputElement) {
                calculatorData.bruto_bulanan_beda[bulan] = inputElement.value;
            }
        });
        
        localStorage.setItem('calculatorFormData_BukanPegawai', JSON.stringify(calculatorData));
    }

    function loadAndRestoreBukanPegawaiData() {
        const savedDataJSON = localStorage.getItem('calculatorFormData_BukanPegawai');
        if (!savedDataJSON) return;

        console.log('Data "Bukan Pegawai" ditemukan, memuat ulang form...');
        const data = JSON.parse(savedDataJSON);

        // 1. Pulihkan semua pilihan radio
        if (data.dibayar_bulanan_value) document.querySelector(`input[name="dibayar_bulanan"][value="${data.dibayar_bulanan_value}"]`).checked = true;
        if (data.pihak_ketiga_value) document.querySelector(`input[name="pihak_ketiga"][value="${data.pihak_ketiga_value}"]`).checked = true;
        if (data.bulanan_sama_value) document.querySelector(`input[name="bin"][value="${data.bulanan_sama_value}"]`).checked = true;

        // 2. Atur visibilitas form berdasarkan pilihan radio
        const isBulanan = data.dibayar_bulanan_value === '0';
        document.getElementById('bulanan').style.display = isBulanan ? 'block' : 'none';
        document.getElementById('tidakBulanan').style.display = isBulanan ? 'none' : 'block';
        document.getElementById('bulanan-sama-wrap').style.display = 'none';
        document.getElementById('bulanan-beda-wrap').style.display = 'none';
        document.getElementById('tidak-bulanan-wrap').style.display = 'none';
        
        if (isBulanan) {
            const isSama = data.bulanan_sama_value === '0';
            document.getElementById('tiapBulanSama').style.display = isSama ? 'block' : 'none';
            document.getElementById('tiapBulanBeda').style.display = isSama ? 'none' : 'block';
            document.getElementById('bulanan-sama-wrap').style.display = isSama ? 'block' : 'none';
            document.getElementById('bulanan-beda-wrap').style.display = isSama ? 'none' : 'block';
        } else {
            const adaPihakKetiga = data.pihak_ketiga_value === '0';
            document.getElementById('yaPihak').style.display = adaPihakKetiga ? 'block' : 'none';
            document.getElementById('tidak-bulanan-wrap').style.display = 'block';
        }

        // 3. Isi kembali semua nilai input dan hasil
        document.getElementById('floatingTerpotong').value = data.total_bruto_tidak_bulanan;
        document.getElementById('floatingPihakKetiga').value = data.biaya_pihak_ketiga;
        document.getElementById('floatingGaji').value = data.bruto_bulanan_sama;
        document.getElementById('floatingInput').value = data.jumlah_bulan_bekerja;
        
        if (data.bruto_bulanan_beda) {
            bulanList.forEach(bulan => {
                const inputElement = document.getElementById(bulan);
                if (inputElement && data.bruto_bulanan_beda[bulan] !== undefined) {
                    inputElement.value = data.bruto_bulanan_beda[bulan];
                }
            });
        }
        
        document.getElementById('netoTidakBulanan').textContent = data.netoTidakBulanan_text;
        document.querySelector('#tidak-bulanan-wrap .res-field:nth-of-type(2) .res').textContent = data.metodeHitungTidakBulanan_text;
        document.querySelector('#tidak-bulanan-wrap .res-field:nth-of-type(3) .res').textContent = data.tarifTidakBulanan_text;
        
        document.getElementById('metodeHitungSama').textContent = data.metodeHitungSama_text;
        document.querySelector('#bulanan-sama-wrap .res-field:nth-of-type(2) .res').textContent = data.tarifSama_text;
        document.getElementById('pphRataSama').textContent = data.pphRataSama_text;
        
        document.getElementById('metodeHitungBeda').textContent = data.metodeHitungBeda_text;

        document.querySelector('.total.grand .rp-total').textContent = data.pph21_terutang_text;

        // 4. Hapus data dari localStorage
        localStorage.removeItem('calculatorFormData_BukanPegawai');
        console.log('Data "Bukan Pegawai" dari localStorage telah dimuat dan dihapus.');
    }

    // Jalankan pemulihan data saat halaman dimuat
    loadAndRestoreBukanPegawaiData();

    // =================================================================================
    // EVENT LISTENER UNTUK TOMBOL (KODE ASLI ANDA YANG DIMODIFIKASI)
    // =================================================================================

    document.getElementById('pay-now').addEventListener('click', async function () {
    const isLoggedIn = document.body.getAttribute('data-authenticated') === 'true';

    if (!isLoggedIn) {
      saveBukanPegawaiDataToLocalStorage()
      // Ambil URL halaman kalkulator saat ini
      const redirectUrl = window.location.pathname; // Hasilnya akan seperti "/halaman-kalkulator"

      // Arahkan ke halaman login DENGAN menyertakan URL tujuan
      // Ini akan menghasilkan URL seperti: /login?redirect_to=/halaman-kalkulator
      window.location.href = '/login?redirect_to=' + redirectUrl;
      
      return; // Hentikan eksekusi skrip
  }

    const parseRupiah = (str) => parseInt((str || '').replace(/[^\d]/g, '') || '0');

    const isBulanan = document.querySelector('input[name="dibayar_bulanan"]:checked')?.value === "0";
    const isSama = document.querySelector('input#sama')?.checked;
    const isBeda = document.querySelector('input#tidakSama')?.checked;
    const pihakKetiga = document.querySelector('input[name="pihak_ketiga"]:checked')?.value === "0";

    const bulanList = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    const data = {
        dibayar_bulanan: isBulanan ? 1 : 0,
        bulanan_sama: isSama ? 1 : 0,
        metode_penghitungan: document.querySelector('#metodeHitungSama')?.textContent || document.querySelector('#metodeHitungBeda')?.textContent || document.querySelector('#tidak-bulanan-wrap p.res:nth-child(2)')?.textContent || '-',
        tarif: document.querySelector('#bulanan-sama-wrap p.res:nth-child(2)')?.textContent ||
               document.querySelector('#bulanan-beda-wrap p.res:nth-child(2)')?.textContent ||
               document.querySelector('#tidak-bulanan-wrap p.res:nth-child(3)')?.textContent || '-',
        pph21_terutang: parseRupiah(document.querySelector('.rp-total').textContent || '0'),
    };

    // Bulanan sama
    if (isBulanan && isSama) {
        data.bruto_perbulan = parseRupiah(document.getElementById('floatingGaji').value);
        data.banyak_bulan_bekerja = parseInt(document.getElementById('floatingInput').value || '0');
        data.pph21_perbulan = parseRupiah(document.getElementById('pphRataSama').textContent);
    }

    // Bulanan beda
    if (isBulanan && isBeda) {
        bulanList.forEach((bulan) => {
          const key = bulan.toLowerCase().slice(0, 3);
          data[`bruto_${key}`] = parseRupiah(document.getElementById(bulan).value || '0');

          const pajakElem = document.getElementById(`pajak-${key}`);
          data[`pajak_${key}`] = pajakElem ? parseRupiah(pajakElem.textContent || '0') : 0;
      });
    }

    // Tidak bulanan
    if (!isBulanan) {
        data.total_bruto = parseRupiah(document.getElementById('floatingTerpotong').value);
        data.pihak_ketiga = pihakKetiga ? 1 : 0;
        data.biaya_pihak_ketiga = pihakKetiga ? parseRupiah(document.getElementById('floatingPihakKetiga').value) : 0;
        data.penghasilan_neto = parseRupiah(document.getElementById('netoTidakBulanan').textContent);
    }

    fetch('/bukan-pegawai/store', {
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
                // const error = await response.json();
                // window.scrollTo({ top: 0, behavior: 'smooth' });
                // alert('Gagal: ' + Object.values(error.errors).flat().join(', '));
                return response.json().then(error => {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                      // Bersihkan semua error dulu
                      document.querySelectorAll('[id^="error-"]').forEach(el => el.textContent = '');

                      // Tampilkan error dari Laravel
                      for (let field in error.errors) {
                        console.log(field)
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
      saveBukanPegawaiDataToLocalStorage()
      // Ambil URL halaman kalkulator saat ini
      const redirectUrl = window.location.pathname; // Hasilnya akan seperti "/halaman-kalkulator"

      // Arahkan ke halaman login DENGAN menyertakan URL tujuan
      // Ini akan menghasilkan URL seperti: /login?redirect_to=/halaman-kalkulator
      window.location.href = '/login?redirect_to=' + redirectUrl;
      
      return; // Hentikan eksekusi skrip
  }

    const parseRupiah = (str) => parseInt((str || '').replace(/[^\d]/g, '') || '0');

    const isBulanan = document.querySelector('input[name="dibayar_bulanan"]:checked')?.value === "0";
    const isSama = document.querySelector('input#sama')?.checked;
    const isBeda = document.querySelector('input#tidakSama')?.checked;
    const pihakKetiga = document.querySelector('input[name="pihak_ketiga"]:checked')?.value === "0";

    const bulanList = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    const data = {
        dibayar_bulanan: isBulanan ? 1 : 0,
        bulanan_sama: isSama ? 1 : 0,
        metode_penghitungan: document.querySelector('#metodeHitungSama')?.textContent || document.querySelector('#metodeHitungBeda')?.textContent || document.querySelector('#tidak-bulanan-wrap p.res:nth-child(2)')?.textContent || '-',
        tarif: document.querySelector('#bulanan-sama-wrap p.res:nth-child(2)')?.textContent ||
               document.querySelector('#bulanan-beda-wrap p.res:nth-child(2)')?.textContent ||
               document.querySelector('#tidak-bulanan-wrap p.res:nth-child(3)')?.textContent || '-',
        pph21_terutang: parseRupiah(document.querySelector('.rp-total').textContent || '0'),
    };

    // Bulanan sama
    if (isBulanan && isSama) {
        data.bruto_perbulan = parseRupiah(document.getElementById('floatingGaji').value);
        data.banyak_bulan_bekerja = parseInt(document.getElementById('floatingInput').value || '0');
        data.pph21_perbulan = parseRupiah(document.getElementById('pphRataSama').textContent);
    }

    // Bulanan beda
    if (isBulanan && isBeda) {
        bulanList.forEach((bulan) => {
          const key = bulan.toLowerCase().slice(0, 3);
          data[`bruto_${key}`] = parseRupiah(document.getElementById(bulan).value || '0');

          const pajakElem = document.getElementById(`pajak-${key}`);
          data[`pajak_${key}`] = pajakElem ? parseRupiah(pajakElem.textContent || '0') : 0;
      });
    }

    // Tidak bulanan
    if (!isBulanan) {
        data.total_bruto = parseRupiah(document.getElementById('floatingTerpotong').value);
        data.pihak_ketiga = pihakKetiga ? 1 : 0;
        data.biaya_pihak_ketiga = pihakKetiga ? parseRupiah(document.getElementById('floatingPihakKetiga').value) : 0;
        data.penghasilan_neto = parseRupiah(document.getElementById('netoTidakBulanan').textContent);
    }

    fetch('/bukan-pegawai/store', {
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
                // const error = await response.json();
                // window.scrollTo({ top: 0, behavior: 'smooth' });
                // alert('Gagal: ' + Object.values(error.errors).flat().join(', '));
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

    // Event listener lainnya (jika ada) bisa diletakkan di sini
});
