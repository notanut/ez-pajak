document.addEventListener('DOMContentLoaded', function () {

    // ▼▼▼ BAGIAN 1: FUNGSI PEMBANTU (HELPERS) ▼▼▼

    function parseRupiah(str) {
        if (!str || typeof str !== 'string') return 0;
        // Cukup hapus semua karakter yang bukan digit.
        const numberString = String(str).replace(/\D/g, '');
        return parseInt(numberString || 0);
    }

    function formatRupiah(value) {
        // Gunakan parseFloat untuk membaca format angka dari database dengan benar.
        const numberValue = parseFloat(value) || 0;
        return 'Rp ' + new Intl.NumberFormat('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(Math.floor(numberValue));
    }

    function getFormData() {
        const isBulanan = document.getElementById('dibayar-ya').checked;
        const isSama = document.getElementById('sama').checked;
        const pihakKetiga = document.getElementById('ketiga-ya').checked;

        const bulanMap = {
            Januari: 'jan', Februari: 'feb', Maret: 'mar', April: 'apr',
            Mei: 'mei', Juni: 'jun', Juli: 'jul', Agustus: 'agu',
            September: 'sep', Oktober: 'okt', November: 'nov', Desember: 'des'
        };

        const data = {
            // FIX: Kirim 1/0 bukan true/false
            dibayar_bulanan: isBulanan ? 1 : 0,
            bulanan_sama: isBulanan ? (isSama ? 1 : 0) : 0,
            metode_penghitungan: '-', // Akan diisi di bawah
            tarif: '-', // Akan diisi di bawah
            pph21_terutang: parseRupiah(document.querySelector('.rp-total').textContent || '0'),
        };

        if (isBulanan) {
            if (isSama) {
                data.metode_penghitungan = document.getElementById('metodeHitungSama').textContent;
                data.tarif = document.querySelector('#bulanan-sama-wrap .res-field:nth-of-type(2) .res').textContent;
                data.bruto_perbulan = parseRupiah(document.getElementById('floatingGaji').value);
                data.banyak_bulan_bekerja = parseInt(document.getElementById('floatingInput').value || '0');
                data.pph21_perbulan = parseRupiah(document.getElementById('pphRataSama').textContent);
            } else {
                data.metode_penghitungan = document.getElementById('metodeHitungBeda').textContent;
                Object.entries(bulanMap).forEach(([bulan, key]) => {
                    data[`bruto_${key}`] = parseRupiah(document.getElementById(bulan)?.value || '0');
                    const pajakElem = document.getElementById(`pajak-${key}`);
                    data[`pajak_${key}`] = pajakElem ? parseRupiah(pajakElem.textContent || '0') : 0;
                });
            }
        } else {
            data.metode_penghitungan = document.querySelector('#tidak-bulanan-wrap .res-field:nth-of-type(2) .res').textContent;
            data.tarif = document.querySelector('#tidak-bulanan-wrap .res-field:nth-of-type(3) .res').textContent;
            data.total_bruto = parseRupiah(document.getElementById('floatingTerpotong').value);
            data.pihak_ketiga = pihakKetiga;
            data.biaya_pihak_ketiga = pihakKetiga ? parseRupiah(document.getElementById('floatingPihakKetiga').value) : 0;
            data.penghasilan_neto = parseRupiah(document.getElementById('netoTidakBulanan').textContent);
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

    // DIKEMBALIKAN: Fungsi untuk menyimpan data ke localStorage
    function saveBukanPegawaiDataToLocalStorage() {
        console.log('User tidak login, menyimpan data "Bukan Pegawai" ke localStorage...');
        const bulanList = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        const calculatorData = {
            dibayar_bulanan_value: document.querySelector('input[name="dibayar_bulanan"]:checked')?.value,
            pihak_ketiga_value: document.querySelector('input[name="pihak_ketiga"]:checked')?.value,
            bulanan_sama_value: document.querySelector('input[name="bin"]:checked')?.value,
            total_bruto_tidak_bulanan: document.getElementById('floatingTerpotong').value,
            biaya_pihak_ketiga: document.getElementById('floatingPihakKetiga').value,
            bruto_bulanan_sama: document.getElementById('floatingGaji').value,
            jumlah_bulan_bekerja: document.getElementById('floatingInput').value,
            bruto_bulanan_beda: {},
        };
        bulanList.forEach(bulan => {
            const inputElement = document.getElementById(bulan);
            if (inputElement) {
                calculatorData.bruto_bulanan_beda[bulan] = inputElement.value;
            }
        });
        localStorage.setItem('calculatorFormData_BukanPegawai', JSON.stringify(calculatorData));
    }

    // DIKEMBALIKAN: Fungsi untuk memuat data dari localStorage
    function loadAndRestoreBukanPegawaiData() {
        const savedDataJSON = localStorage.getItem('calculatorFormData_BukanPegawai');
        if (!savedDataJSON) return;
        console.log('Data "Bukan Pegawai" ditemukan, memuat ulang form...');
        const data = JSON.parse(savedDataJSON);

        if (data.dibayar_bulanan_value) document.querySelector(`input[name="dibayar_bulanan"][value="${data.dibayar_bulanan_value}"]`).checked = true;
        if (data.pihak_ketiga_value) document.querySelector(`input[name="pihak_ketiga"][value="${data.pihak_ketiga_value}"]`).checked = true;
        if (data.bulanan_sama_value) document.querySelector(`input[name="bin"][value="${data.bulanan_sama_value}"]`).checked = true;

        document.getElementById('floatingTerpotong').value = data.total_bruto_tidak_bulanan;
        document.getElementById('floatingPihakKetiga').value = data.biaya_pihak_ketiga;
        document.getElementById('floatingGaji').value = data.bruto_bulanan_sama;
        document.getElementById('floatingInput').value = data.jumlah_bulan_bekerja;

        if (data.bruto_bulanan_beda) {
            Object.keys(data.bruto_bulanan_beda).forEach(bulan => {
                const inputElement = document.getElementById(bulan);
                if (inputElement && data.bruto_bulanan_beda[bulan] !== undefined) {
                    inputElement.value = data.bruto_bulanan_beda[bulan];
                }
            });
        }
        localStorage.removeItem('calculatorFormData_BukanPegawai');
    }


    // ▼▼▼ BAGIAN 2: FUNGSI INTI (PERHITUNGAN, TAMPILAN, DLL) ▼▼▼
    // (Semua fungsi inti dari file Anda dipertahankan di sini)
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
        let prevBatas = 0; // Untuk menghitung per lapisan
        for (const { batas, tarif } of tarifPasal17) {
            if (sisa <= 0) break;
            const kenaPajakDiLapisIni = Math.min(sisa, batas - prevBatas);
            if (kenaPajakDiLapisIni > 0) {
                pajak += kenaPajakDiLapisIni * tarif;
                tarifUsed.add(tarif);
                sisa -= kenaPajakDiLapisIni;
            }
            prevBatas = batas;
        }
        return { pajak, tarifUsed };
    };

    const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

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

    function calculateTaxDates() {
        const today = new Date();
        const currentYear = today.getFullYear();

        const akhirTahunPajak = new Date(`${currentYear}-12-31`);
        const jatuhTempo = new Date(`${currentYear + 1}-03-31`);

        function getCountdown(targetDate) {
        const diffMs = targetDate - today;
        if (diffMs < 0) return "Sudah lewat";

        const diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));
        const months = Math.floor(diffDays / 30.44);
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

    function updateDisplay() {
        const pilihanBulanan = document.querySelector('input[name="dibayar_bulanan"]:checked');
        const pilihanSama = document.querySelector('input[name="bin"]:checked');
        const pilihanPihakKetiga = document.querySelector('input[name="pihak_ketiga"]:checked');

        // 1. Sembunyikan semua bagian form dan hasil terlebih dahulu
        document.getElementById('bulanan').style.display = 'none';
        document.getElementById('tidakBulanan').style.display = 'none';
        document.getElementById('tiapBulanSama').style.display = 'none';
        document.getElementById('tiapBulanBeda').style.display = 'none';
        document.getElementById('yaPihak').style.display = 'none';
        document.getElementById('bulanan-sama-wrap').style.display = 'none';
        document.getElementById('bulanan-beda-wrap').style.display = 'none';
        document.getElementById('tidak-bulanan-wrap').style.display = 'none';

        // 2. Jika belum ada pilihan bulanan, hentikan fungsi. Form akan kosong.
        if (!pilihanBulanan) {
            return;
        }

        // 3. Tampilkan bagian berdasarkan pilihan yang sudah dibuat
        // Jika ada pilihan bulanan (termasuk saat halaman edit dimuat)
        if (pilihanBulanan) {
            if (pilihanBulanan.id === 'dibayar-ya') {
                document.getElementById('bulanan').style.display = 'block';
                // Tampilkan sub-bagian hanya jika ada pilihan
                if (pilihanSama) {
                    if (pilihanSama.id === 'sama') {
                        document.getElementById('tiapBulanSama').style.display = 'block';
                        document.getElementById('bulanan-sama-wrap').style.display = 'block';
                    } else {
                        document.getElementById('tiapBulanBeda').style.display = 'block';
                        document.getElementById('bulanan-beda-wrap').style.display = 'block';
                    }
                }
            } else { // Jika pilihan adalah "Tidak"
                document.getElementById('tidakBulanan').style.display = 'block';
                document.getElementById('tidak-bulanan-wrap').style.display = 'block';
                if (pilihanPihakKetiga && pilihanPihakKetiga.id === 'ketiga-ya') {
                    document.getElementById('yaPihak').style.display = 'block';
                }
            }
        }
    }

    // ▼▼▼ BAGIAN 3: INISIALISASI HALAMAN DAN EVENT LISTENERS ▼▼▼

    function setupEventListeners() {
        // Mengembalikan listener format Rupiah dari file asli Anda
        document.querySelectorAll('.rp').forEach(input => {
            input.addEventListener('input', function () {
                let value = this.value.replace(/\D/g, '');
                this.value = value ? 'Rp ' + new Intl.NumberFormat('id-ID').format(value) : '';
            });
        });

        // Listener umum untuk semua input dan select
        document.querySelectorAll('input, select').forEach(el => {
            // 'input' untuk perubahan langsung saat mengetik
            el.addEventListener('input', hitung);
            // 'change' untuk perubahan setelah selesai (klik radio, pilih dropdown)
            // Ini akan memicu update tampilan dan perhitungan ulang
            el.addEventListener('change', () => {
                updateDisplay();
                hitung();
            });
        });
    }

    function initializePage() {
        setupEventListeners();
        calculateTaxDates();

        if (window.bukanPegawaiData) { // Cek jika kita dalam mode edit
            console.log("Mode Edit terdeteksi, menerapkan data dari server.");

            // Atur semua radio button sesuai data dari server
            if (window.bukanPegawaiData.dibayar_bulanan == 1) { document.getElementById('dibayar-ya').checked = true; } else { document.getElementById('dibayar-tidak').checked = true; }
            if (window.bukanPegawaiData.bulanan_sama == 1) { document.getElementById('sama').checked = true; } else { document.getElementById('tidakSama').checked = true; }
            if (window.bukanPegawaiData.pihak_ketiga == 1) { document.getElementById('ketiga-ya').checked = true; } else { document.getElementById('ketiga-tidak').checked = true; }

            // FIX: Format nilai dari database (yang berupa angka mentah) HANYA di mode edit.
            document.querySelectorAll('.rp').forEach(input => {
                if (input.value) {
                    input.value = formatRupiah(input.value);
                }
            });

        } else {
            // Jika bukan mode edit, jalankan logika untuk pengguna tamu.
            // Fungsi ini akan mengisi form dengan data yang sudah diformat dari localStorage.
            loadAndRestoreBukanPegawaiData();
        }

        // Panggil updateDisplay dan hitung SETELAH semua data (baik dari server atau localStorage) dimuat
        updateDisplay();
        hitung();
    }

    // Jalankan semua proses inisialisasi
    initializePage();


    // ▼▼▼ BAGIAN 4: LOGIKA TOMBOL AKSI (STORE & UPDATE) ▼▼▼

    async function handleSubmission(isUpdate = false, isRemindLater = false) {
        const data = getFormData();
        const url = isUpdate ? `/bukan-pegawai/${window.transaksiData.id}` : '/bukan-pegawai/store';
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
                } else if (result.user_id) {
                    window.location.href = `/payment/paypage/${result.transaksi_id}`;
                } else {
                    window.location.href = '/home'; // fallback untuk remind later
                }
            }

        } catch (error) {
            console.error('Submission error:', error);
        }
    }

    // Pendaftaran Listener untuk Tombol Aksi
    const payNowButton = document.getElementById('pay-now');
    if (payNowButton) {
        payNowButton.addEventListener('click', () => {
            // DIKEMBALIKAN: Pengecekan status login
            const isLoggedIn = document.body.getAttribute('data-authenticated') === 'true';
            if (isLoggedIn) {
                // handleSubmission(false, false);
                handleSubmission(false, true);
            } else {
                saveBukanPegawaiDataToLocalStorage();
                window.location.href = `/login?redirect_to=${window.location.pathname}`;
            }
        });
    }

    const remindLaterButton = document.getElementById('remind-later');
    if (remindLaterButton) {
        remindLaterButton.addEventListener('click', () => {
            // DIKEMBALIKAN: Pengecekan status login
            const isLoggedIn = document.body.getAttribute('data-authenticated') === 'true';
            if (isLoggedIn) {
                handleSubmission(false, true);
            } else {
                saveBukanPegawaiDataToLocalStorage();
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
