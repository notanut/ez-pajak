// Semua logika kini dibungkus dalam satu event listener untuk memastikan
// semua elemen HTML siap sebelum skrip dijalankan.
document.addEventListener('DOMContentLoaded', function () {

    // ▼▼▼ BAGIAN 1: FUNGSI PEMBANTU (HELPERS) ▼▼▼

    function parseRupiah(str) {
        // Fungsi ini sekarang hanya perlu menghapus karakter non-digit,
        // karena format di halaman sudah distandarisasi menjadi "Rp 6.000.000"
        if (!str || typeof str !== 'string') return 0;
        return parseInt(str.replace(/\D/g, '') || 0);
    }

    function formatRupiah(value) {
        // Menggunakan parseFloat untuk memastikan nilai desimal dari database terbaca benar
        const numberValue = parseFloat(value) || 0;
        // Membulatkan ke bawah dan memformat tanpa desimal untuk konsistensi
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.floor(numberValue));
    }

    function getFormData() {
        const isBulanan = document.getElementById('dibayar-ya').checked;
        const isSama = document.getElementById('sama').checked;
        const isBeda = document.getElementById('tidakSama').checked;

        const bulanMap = {
            Januari: 'jan', Februari: 'feb', Maret: 'mar', April: 'apr',
            Mei: 'mei', Juni: 'jun', Juli: 'jul', Agustus: 'agu',
            September: 'sep', Oktober: 'okt', November: 'nov', Desember: 'des'
        };

        const data = {
            jenis_kelamin: document.querySelector('input[name="sex"]:checked')?.value,
            status_perkawinan: document.getElementById('floatingSelect').value,
            tanggungan: parseInt(document.getElementById('jmlTanggungan').value || '0'),
            dibayar_bulanan: isBulanan,
            pph21_terutang: parseRupiah(document.getElementById('rp-total').textContent)
        };

        if (isBulanan) {
            data.bulanan_sama = isSama;
            if (isSama) {
                data.metode_penghitungan = document.getElementById('metodeHitungSama').textContent;
                data.bruto_perbulan = parseRupiah(document.getElementById('brutoBulanan').value);
                data.banyak_bulan_bekerja = parseInt(document.getElementById('jmlBulan').value || '0');
                data.pph21_perbulan = parseRupiah(document.getElementById('pphRataSama').textContent);
            } else { // isBeda
                data.metode_penghitungan = document.getElementById('metodeHitungBeda').textContent;
                Object.entries(bulanMap).forEach(([bulan, key]) => {
                    data[`bruto_${key}`] = parseRupiah(document.getElementById(bulan)?.value || '0');
                    const pajakElem = document.getElementById(`pajak-${key}`);
                    data[`pajak_${key}`] = pajakElem ? parseRupiah(pajakElem.textContent || '0') : 0;
                });
            }
        } else { // Tidak Bulanan
            data.bulanan_sama = false;
            data.metode_penghitungan = document.getElementById('metodeHitungTidakBulan').textContent;
            data.total_bruto = parseRupiah(document.getElementById('brutoProyek').value);
            data.lama_hari_bekerja = parseInt(document.getElementById('lamaKerja').value || '0');
            data.avg_bruto = parseRupiah(document.getElementById('avBruto').textContent);
            data.pph21_perhari = parseRupiah(document.getElementById('pphRataHari').textContent);
        }
        return data;
    }

    function displayValidationErrors(errors) {
        window.scrollTo({ top: 0, behavior: 'smooth' });
        document.querySelectorAll('[id^="error-"]').forEach(el => el.textContent = '');
        for (const field in errors) {
            const target = document.getElementById(`error-${field}`);
            if (target) {
                target.textContent = errors[field][0];
            }
        }
    }

    // ▼▼▼ BAGIAN 2: FUNGSI INTI (PERHITUNGAN, TAMPILAN, DLL) ▼▼▼

    const TERBulanan = { /* ... Objek TER Anda yang besar tidak diubah ... */
        A: [ [5400000, 0], [5650000, 0.0025], [5950000, 0.005], [6300000, 0.0075], [6750000, 0.01], [7500000, 0.0125], [8550000, 0.015], [9650000, 0.0175], [10950000, 0.02], [10350000, 0.0225], [10700000, 0.025], [11050000, 0.03], [11500000, 0.035], [12500000, 0.04], [13750000, 0.05], [15100000, 0.06], [16590000, 0.07], [19750000, 0.08], [21450000, 0.09], [26450000, 0.1], [28000000, 0.11], [30500000, 0.12], [32400000, 0.13], [35400000, 0.14], [39100000, 0.15], [43850000, 0.16], [47800000, 0.17], [51400000, 0.18], [56500000, 0.19], [62200000, 0.2], [68600000, 0.21], [77500000, 0.22], [89000000, 0.23], [103000000, 0.24], [125000000, 0.25], [157000000, 0.26], [206000000, 0.27], [337000000, 0.28], [454000000, 0.29], [550000000, 0.3], [695000000, 0.31], [910000000, 0.32], [1400000000, 0.33], [Infinity, 0.34] ],
        B: [ [6200000, 0], [6500000, 0.0025], [6850000, 0.005], [7300000, 0.0075], [7900000, 0.01], [8750000, 0.0125], [10750000, 0.015], [11250000, 0.02], [11600000, 0.03], [12600000, 0.04], [13600000, 0.05], [14950000, 0.06], [16400000, 0.07], [18450000, 0.08], [21850000, 0.09], [26000000, 0.1], [27700000, 0.11], [29350000, 0.12], [33500000, 0.13], [37000000, 0.14], [41000000, 0.15], [45800000, 0.16], [49500000, 0.17], [53800000, 0.18], [58500000, 0.19], [64000000, 0.2], [71000000, 0.21], [80000000, 0.22], [93000000, 0.23], [109000000, 0.24], [134000000, 0.25], [169000000, 0.26], [221000000, 0.27], [374000000, 0.28], [459000000, 0.29], [555000000, 0.3], [704000000, 0.31], [957000000, 0.32], [1405000000, 0.33], [Infinity, 0.34] ],
        C: [ [6600000, 0], [6950000, 0.0025], [7350000, 0.005], [7800000, 0.0075], [8850000, 0.0125], [9900000, 0.015], [10950000, 0.0175], [11200000, 0.02], [12950000, 0.03], [14150000, 0.04], [15550000, 0.05], [17050000, 0.06], [19500000, 0.07], [22700000, 0.08], [26600000, 0.09], [28000000, 0.1], [30100000, 0.11], [32100000, 0.12], [35400000, 0.13], [38900000, 0.14], [43000000, 0.15], [47400000, 0.16], [51800000, 0.17], [56600000, 0.18], [62500000, 0.19], [66700000, 0.2], [74500000, 0.21], [83200000, 0.22], [95600000, 0.23], [110000000, 0.24], [134000000, 0.25], [169000000, 0.26], [221000000, 0.27], [390000000, 0.28], [463000000, 0.29], [561000000, 0.3], [709000000, 0.31], [965000000, 0.32], [1419000000, 0.33], [Infinity, 0.34] ] };

    function getTERKategori(gender, kawin, tanggungan) { /* ... Fungsi ini tidak diubah ... */
        if (gender === '1' && kawin === '0') return 'A';
        if (kawin === '0' && tanggungan <= 1) return 'A';
        if (kawin === '0' && tanggungan >= 2) return 'B';
        if (kawin === '1' && tanggungan === 0) return 'A';
        if (kawin === '1' && tanggungan <= 2) return 'B';
        if (kawin === '1' && tanggungan === 3) return 'C';
        return 'A'; }
    function getTERTarif(kategori, bruto) { /* ... Fungsi ini tidak diubah ... */
        for (let [batas, tarif] of TERBulanan[kategori])
            { if (bruto <= batas) return tarif; }
        return 0.05;
    }
    function getTarifPasal17(pkp) { /* ... Fungsi ini tidak diubah ... */
        if (pkp <= 60000000) return 0.05;
        if (pkp <= 250000000) return 0.15;
        if (pkp <= 500000000) return 0.25;
        if (pkp <= 5000000000) return 0.30;
        return 0.35;
    }

    function hitung() { /* ... Fungsi `hitung` lengkap Anda dari file asli ditempatkan di sini ... */
        const gender = document.querySelector('input[name="sex"]:checked')?.value || '0';
        const kawin = document.getElementById('floatingSelect').value;
        const tanggungan = parseInt(document.getElementById('jmlTanggungan').value || '0');
        const kategori = getTERKategori(gender, kawin, tanggungan);

        const isBulanan = document.getElementById('dibayar-ya').checked;
        const isSama = document.getElementById('sama').checked;
        const isBeda = document.getElementById('tidakSama').checked;

        let total = 0;
        let pphTotal = 0;

        const bulananBedaWrap = document.getElementById('bulanan-beda-wrap');
        const oldFields = bulananBedaWrap.querySelectorAll('.bulanPajak');
        oldFields.forEach(field => field.remove());

        if (isBulanan && isSama) {
          const bruto = parseRupiah(document.getElementById('brutoBulanan').value);
          const bulan = parseInt(document.getElementById('jmlBulan').value || '0');
          total = bruto * bulan;
          const tarif = getTERTarif(kategori, bruto);
          const pph = bruto * tarif;
          pphTotal = pph * bulan;
          document.getElementById('metodeHitungSama').textContent = `TER Bulanan Kategori ${kategori}`;
          document.getElementById('pphRataSama').textContent = formatRupiah(pph);

        } else if (isBulanan && isBeda) {
            document.getElementById('metodeHitungBeda').textContent = `Penghasilan Bruto Bulanan x TER Bulanan Kategori ${kategori}`;
            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            monthNames.forEach((bulan) => {
                const el = document.getElementById(bulan);
                if (!el) return;
                const val = parseRupiah(el.value || '0');
                if (val <= 0) return;

                total += val;
                const tarif = getTERTarif(kategori, val);
                const pph = val * tarif;
                pphTotal += pph;

                const wrapper = document.createElement('div');
                const key = bulan.toLowerCase().slice(0, 3);
                wrapper.classList.add('res-field', 'bulanPajak');
                wrapper.innerHTML = `<p class="label">${bulan}</p><p id="pajak-${key}" class="res pphBulan">${formatRupiah(pph)}</p>`;
                bulananBedaWrap.appendChild(wrapper);
            });
        } else { // Tidak Bulanan
            const bruto = parseRupiah(document.getElementById('brutoProyek').value);
            const hari = parseInt(document.getElementById('lamaKerja').value || '0');
            const rata = hari > 0 ? bruto / hari : 0;
            document.getElementById('avBruto').textContent = formatRupiah(rata);
            total = bruto;
            let tarif = 0;
            if (rata <= 450000) tarif = 0;
            else if (rata <= 2500000) tarif = 0.005;
            else tarif = 0.5;

            let metode = '';
            if (tarif === 0.5) {
              const pasal17Tarif = getTarifPasal17(bruto * 0.5);
              metode = `50% x Ps.17 (${(pasal17Tarif * 100).toFixed(0)}%)`;
            } else {
              metode = 'TER Harian';
            }

            document.getElementById('metodeHitungTidakBulan').textContent = metode;

            const pph = (tarif === 0.5) ? bruto * 0.5 * getTarifPasal17(bruto * 0.5) : bruto * tarif;
            pphTotal = pph;
            document.getElementById('pphRataHari').textContent = hari > 0 ? formatRupiah(pph / hari) : formatRupiah(0);
        }
        document.getElementById('rp-total').textContent = formatRupiah(pphTotal);
    }

    function calculateTaxDates() { /* ... Fungsi ini tidak diubah ... */
        const today = new Date(); const currentYear = today.getFullYear();
        const akhirTahunPajak = new Date(`${currentYear}-12-31`);
        const jatuhTempo = new Date(`${currentYear + 1}-03-31`);
        function getCountdown(targetDate) { const diffMs = targetDate - today; if (diffMs < 0) return "Sudah lewat"; const diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24)); const months = Math.floor(diffDays / 30.44); const weeks = Math.floor((diffDays % 30.44) / 7); const days = Math.floor((diffDays % 30.44) % 7); let parts = []; if (months) parts.push(`${months} Bulan`); if (weeks) parts.push(`${weeks} Minggu`); if (days) parts.push(`${days} Hari`); return parts.join(" "); }
        document.getElementById("akhir-tahun").textContent = akhirTahunPajak.toLocaleDateString("id-ID", { day: "2-digit", month: "short", year: "numeric" });
        document.getElementById("jatuh-tempo").textContent = jatuhTempo.toLocaleDateString("id-ID", { day: "2-digit", month: "short", year: "numeric" });
        document.getElementById("batas-start").textContent = getCountdown(akhirTahunPajak);
        document.getElementById("batas-end").textContent = getCountdown(jatuhTempo);
    }

    function updateDisplay() {
        // Fungsi ini mengontrol semua `style.display` secara terpusat
        const isBulanan = document.getElementById('dibayar-ya').checked;
        const isSama = document.getElementById('sama').checked;

        document.getElementById('bulanan').style.display = isBulanan ? 'block' : 'none';
        document.getElementById('tidakBulanan').style.display = isBulanan ? 'none' : 'block';

        if (isBulanan) {
            document.getElementById('tiapBulanSama').style.display = isSama ? 'block' : 'none';
            document.getElementById('tiapBulanBeda').style.display = isSama ? 'none' : 'block';
            document.getElementById('bulanan-sama-wrap').style.display = isSama ? 'block' : 'none';
            document.getElementById('bulanan-beda-wrap').style.display = isSama ? 'none' : 'block';
            document.getElementById('tidak-bulanan-wrap').style.display = 'none';
        } else {
            document.getElementById('tiapBulanSama').style.display = 'none';
            document.getElementById('tiapBulanBeda').style.display = 'none';
            document.getElementById('bulanan-sama-wrap').style.display = 'none';
            document.getElementById('bulanan-beda-wrap').style.display = 'none';
            document.getElementById('tidak-bulanan-wrap').style.display = 'block';
        }
    }

    // DIKEMBALIKAN: Fungsi localStorage yang BENAR dari file asli
    function saveTidakTetapDataToLocalStorage() {
        console.log('User tidak login, menyimpan data pegawai tidak tetap ke localStorage...');
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        const calculatorData = {
            // Informasi dasar dari file asli Anda
            jenis_kelamin: document.querySelector('input[name="sex"]:checked')?.value,
            tanggungan: document.getElementById('jmlTanggungan').value,
            status_perkawinan: document.getElementById('floatingSelect').value,
            dibayar_bulanan_value: document.querySelector('input[name="dibayar_bulanan"]:checked')?.value,
            bulanan_sama_ga_value: document.querySelector('input[name="bulananSamaGa"]:checked')?.value,

            // Data Bagian: Tidak Bulanan
            brutoProyek: document.getElementById('brutoProyek').value,
            lamaKerja: document.getElementById('lamaKerja').value,

            // Data Bagian: Bulanan & Penghasilan Sama
            brutoBulanan: document.getElementById('brutoBulanan').value,
            jmlBulan: document.getElementById('jmlBulan').value,

            // Data Bagian: Bulanan & Penghasilan Beda
            bruto_bulanan_beda: {},
        };

        months.forEach(month => {
            const inputElement = document.getElementById(month);
            if (inputElement) {
                calculatorData.bruto_bulanan_beda[month] = inputElement.value;
            }
        });

        localStorage.setItem('calculatorFormData_TidakTetap', JSON.stringify(calculatorData));
    }

    // DIKEMBALIKAN: Fungsi localStorage yang BENAR dari file asli
    function loadAndRestoreTidakTetapData() {
        const savedDataJSON = localStorage.getItem('calculatorFormData_TidakTetap');
        if (!savedDataJSON) return;

        console.log('Data kalkulator pegawai tidak tetap ditemukan, memuat ulang form...');
        const data = JSON.parse(savedDataJSON);
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        if (data.jenis_kelamin) document.querySelector(`input[name="sex"][value="${data.jenis_kelamin}"]`).checked = true;
        document.getElementById('jmlTanggungan').value = data.tanggungan;
        document.getElementById('floatingSelect').value = data.status_perkawinan;
        if (data.dibayar_bulanan_value) document.querySelector(`input[name="dibayar_bulanan"][value="${data.dibayar_bulanan_value}"]`).checked = true;
        if (data.bulanan_sama_ga_value) document.querySelector(`input[name="bulananSamaGa"][value="${data.bulanan_sama_ga_value}"]`).checked = true;

        document.getElementById('brutoProyek').value = data.brutoProyek;
        document.getElementById('lamaKerja').value = data.lamaKerja;
        document.getElementById('brutoBulanan').value = data.brutoBulanan;
        document.getElementById('jmlBulan').value = data.jmlBulan;

        if (data.bruto_bulanan_beda) {
            months.forEach(month => {
                const inputElement = document.getElementById(month);
                if (inputElement && data.bruto_bulanan_beda[month] !== undefined) {
                    inputElement.value = data.bruto_bulanan_beda[month];
                }
            });
        }

        localStorage.removeItem('calculatorFormData_TidakTetap');
        console.log('Data dari localStorage telah dimuat dan dihapus.');
    }


    // ▼▼▼ BAGIAN 3: INISIALISASI HALAMAN DAN EVENT LISTENERS ▼▼▼

    function setupEventListeners() {
        document.querySelectorAll('.rp').forEach(input => {
            input.addEventListener('input', function () {
                let value = this.value.replace(/\D/g, '');
                this.value = value ? 'Rp ' + new Intl.NumberFormat('id-ID').format(value) : '';
            });
        });

        document.querySelectorAll('input, select').forEach(el => {
            el.addEventListener('input', hitung);
            el.addEventListener('change', () => {
                updateDisplay();
                hitung();
            });
        });
    }

    function initializePage() {
        // 1. Siapkan semua event listener dan tanggal
        setupEventListeners();
        calculateTaxDates();

        // 2. Tentukan apakah ini mode "edit" atau mode "tamu"
        if (window.pegawaiTidakTetapData) { // Cek jika data dari server ada (mode edit)
            console.log("Mode Edit terdeteksi, menerapkan data dari server.");

            // Atur semua pilihan radio button sesuai data dari server
            if (window.pegawaiTidakTetapData.jenis_kelamin) {
                document.querySelector(`input[name="sex"][value="${window.pegawaiTidakTetapData.jenis_kelamin}"]`).checked = true;
            }
            if (window.pegawaiTidakTetapData.dibayar_bulanan !== null) {
                document.querySelector(`input[name="dibayar_bulanan"][value="${window.pegawaiTidakTetapData.dibayar_bulanan ? '0' : '1'}"]`).checked = true;
            }
            if (window.pegawaiTidakTetapData.bulanan_sama !== null) {
                document.querySelector(`input[name="bulananSamaGa"][value="${window.pegawaiTidakTetapData.bulanan_sama ? '0' : '1'}"]`).checked = true;
            }

            // FIX: Format nilai dari database (yang berupa angka mentah) HANYA di mode edit.
            document.querySelectorAll('.rp').forEach(input => {
                if (input.value) {
                    input.value = formatRupiah(input.value);
                }
            });

        } else {
            // Jika bukan mode edit, jalankan logika untuk pengguna tamu dari localStorage
            loadAndRestoreTidakTetapData();
        }

        // 3. Panggil updateDisplay dan hitung SETELAH semua data dimuat
        updateDisplay();
        hitung();
    }

    initializePage();


    // ▼▼▼ BAGIAN 4: LOGIKA TOMBOL AKSI (STORE & UPDATE) ▼▼▼

    async function handleSubmission(isUpdate = false, isRemindLater = false) {
        const data = getFormData();
        const url = isUpdate ? `/pegawai-tidak-tetap/${window.transaksiData.id}` : '/pegawai-tidak-tetap/store';
        const method = isUpdate ? 'PUT' : 'POST';

        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (!response.ok) {
                if (response.status === 422) {
                    displayValidationErrors(result.errors);
                }
                throw new Error(result.message || 'Terjadi kesalahan validasi.');
            }

            if (result.success) {
                alert(isUpdate ? 'Data berhasil diperbarui!' : 'Data berhasil disimpan!');
                if (isUpdate || isRemindLater) {
                    window.location.href = '/home';
                } else {
                    window.location.href = `/payment/paypage/${result.transaksi_id}`;
                }
            }

        } catch (error) {
            console.error('Submission error:', error);
        }
    }

    // --- Pendaftaran Listener untuk Tombol Aksi ---

    const payNowButton = document.getElementById('pay-now');
    if (payNowButton) {
        payNowButton.addEventListener('click', () => {
            const isLoggedIn = document.body.getAttribute('data-authenticated') === 'true';
            if (isLoggedIn) {
                handleSubmission(false);
            } else {
                // Panggil fungsi yang BENAR
                saveTidakTetapDataToLocalStorage();
                window.location.href = `/login?redirect_to=${window.location.pathname}`;
            }
        });
    }

    const remindLaterButton = document.getElementById('remind-later');
    if (remindLaterButton) {
        remindLaterButton.addEventListener('click', () => {
            const isLoggedIn = document.body.getAttribute('data-authenticated') === 'true';
            if (isLoggedIn) {
                // Logika 'ingatkan nanti' untuk user yang login
                // handleSubmission(false).then(() => window.location.href = '/home');
                handleSubmission(false, true);
            } else {
                // Panggil fungsi yang BENAR
                saveTidakTetapDataToLocalStorage();
                window.location.href = `/login?redirect_to=${window.location.pathname}`;
            }
        });
    }

    const saveEditButton = document.getElementById('save-edit');
    if (saveEditButton) {
        saveEditButton.addEventListener('click', () => handleSubmission(true));
    }

    const cancelEditButton = document.getElementById('cancel-edit');
    if (cancelEditButton) {
        cancelEditButton.addEventListener('click', () => {
            if (confirm('Anda yakin ingin membatalkan perubahan?')) {
                window.location.href = '/home';
            }
        });
    }
});
