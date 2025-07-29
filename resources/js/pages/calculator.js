document.addEventListener('DOMContentLoaded', function () {

    // ▼▼▼ BAGIAN 1: FUNGSI PEMBANTU (HELPERS) ▼▼▼

    function parseRupiah(str) {
        if (!str || typeof str !== 'string') return 0;
        return parseInt(String(str).replace(/\D/g, '') || 0);
    }

    function formatRupiah(value) {
        const numberValue = parseFloat(String(value).replace(/,/g, '.')) || 0;
        return 'Rp ' + new Intl.NumberFormat('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(Math.floor(numberValue));
    }

    function getFormData() {
        return {
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

    // FUNGSI LOCALSTORAGE DARI FILE ASLI ANDA
    function saveCalculatorDataToLocalStorage() {
        console.log('User tidak login, menyimpan data ke localStorage...');
        const calculatorData = {
            jenis_kelamin: document.querySelector('input[name="sex"]:checked')?.value,
            tanggungan: document.getElementById('floatingInput').value,
            status_perkawinan: document.getElementById('floatingSelect').value,
            masa_awal: document.getElementById('startMonth').value,
            masa_akhir: document.getElementById('endMonth').value,
            disetahunkan: document.querySelector('input[name="spdn"]:checked')?.value,
            gaji: document.getElementById('floatingGaji').value,
            tunjangan_pph: document.getElementById('floatingPPh').value,
            tunjangan_lain: document.getElementById('floatingLain').value,
            honor: document.getElementById('floatingHonor').value,
            premi: document.getElementById('floatingPremi').value,
            natura: document.getElementById('floatingNatura').value,
            tantiem: document.getElementById('floatingTantiem').value,
            iuran_pensiun: document.getElementById('floatingTHT').value,
            zakat: document.getElementById('floatingZakar').value,
            penghasilan_neto_masa_sebelumnya: document.getElementById('floatingMasaSebelum').value,
            pph21_dipotong_masa_sebelum: document.getElementById('floatingTerpotong').value,
        };
        localStorage.setItem('calculatorFormData_PegawaiTetap', JSON.stringify(calculatorData));
    }

    // FUNGSI LOCALSTORAGE DARI FILE ASLI ANDA
    function loadAndRestoreCalculatorData() {
        const savedDataJSON = localStorage.getItem('calculatorFormData_PegawaiTetap');
        if (!savedDataJSON) return;

        console.log('Data kalkulator ditemukan, memuat ulang form...');
        const data = JSON.parse(savedDataJSON);

        if (data.jenis_kelamin) document.querySelector(`input[name="sex"][value="${data.jenis_kelamin}"]`).checked = true;
        document.getElementById('floatingInput').value = data.tanggungan;
        document.getElementById('floatingSelect').value = data.status_perkawinan;
        document.getElementById('startMonth').value = data.masa_awal;
        document.getElementById('endMonth').value = data.masa_akhir;
        if (data.disetahunkan) document.querySelector(`input[name="spdn"][value="${data.disetahunkan}"]`).checked = true;

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

        localStorage.removeItem('calculatorFormData_PegawaiTetap');
    }

    // ▼▼▼ BAGIAN 2: FUNGSI INTI ▼▼▼

    function hitung() {
        const bulanAwal = document.getElementById('startMonth').value;
        const bulanAkhir = document.getElementById('endMonth').value;
        const bulanMulai = bulanAwal ? parseInt(bulanAwal.split('-')[1]) : 1;
        const bulanSelesai = bulanAkhir ? parseInt(bulanAkhir.split('-')[1]) : 12;
        const totalBulan = bulanSelesai - bulanMulai + 1;

        let isDisetahunkan = false;
        if (bulanAwal && bulanAkhir && (bulanAwal !== '2025-01' || bulanAkhir !== '2025-12')) {
            isDisetahunkan = document.getElementById('spdn-tidak')?.checked ?? false;
        }

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
        const netoMasaSebelum = parseRupiah(document.getElementById('floatingMasaSebelum').value);
        const tanggungan = parseInt(document.getElementById('floatingInput').value || '0');
        const statusKawin = document.getElementById('floatingSelect').value;
        const gender = document.querySelector('input[name="sex"]:checked')?.value;
        const penghasilanBruto = gaji + tunjPPh + tunjLain + honor + premi + natura + tantiem;
        const biayaJabatanMax = Math.min(penghasilanBruto * 0.05, 500000 * totalBulan);
        const totalPengurangan = biayaJabatanMax + iuranTHT + zakat;
        const penghasilanNeto = penghasilanBruto - totalPengurangan;
        const netoTotal = penghasilanNeto + netoMasaSebelum;
        const netoUntukPPh = (isDisetahunkan ? (netoTotal / totalBulan * 12) : netoTotal);
        let ptkp = 54000000;
        const jumlahTanggungan = Math.min(3, tanggungan);
        if (statusKawin === 'Kawin' && gender === 'Pria') { ptkp += 4500000 + (jumlahTanggungan * 4500000); }
        else if (statusKawin !== 'Kawin') { ptkp += jumlahTanggungan * 4500000; }
        const pkp = Math.max(0, netoUntukPPh - ptkp);
        let pph21Setahun = 0;
        let sisaPKP = pkp;
        const tarif = [0.05, 0.15, 0.25, 0.3, 0.35];
        const batas = [60000000, 250000000, 500000000, 5000000000];
        let tarifDikenakan = '0%';
        if (pkp > 0) {
            tarifDikenakan = '5%';
            if (pkp > 60000000) tarifDikenakan += ' - 15%';
            if (pkp > 250000000) tarifDikenakan += ' - 25%';
            if (pkp > 500000000) tarifDikenakan += ' - 30%';
            if (pkp > 5000000000) tarifDikenakan += ' - 35%';
        }
        for (let i = 0; i < batas.length; i++) {
            const lower = i === 0 ? 0 : batas[i - 1];
            const upper = batas[i];
            const lapis = Math.min(sisaPKP, upper - lower);
            if (lapis > 0) { pph21Setahun += lapis * tarif[i]; sisaPKP -= lapis; }
        }
        if (sisaPKP > 0) pph21Setahun += sisaPKP * tarif[tarif.length - 1];
        const pph21Fin = isDisetahunkan ? pph21Setahun * totalBulan / 12 : pph21Setahun;
        const pph21pkp = Math.max(0, pph21Fin);
        const pph21MasaIni = Math.max(0, pph21Fin - pphTerpotong);
        document.getElementById('biayaJabatan').textContent = formatRupiah(biayaJabatanMax);
        document.querySelectorAll('.rp-total')[0].textContent = formatRupiah(penghasilanBruto);
        document.querySelectorAll('.rp-total')[1].textContent = formatRupiah(totalPengurangan);
        document.querySelectorAll('.res')[0].textContent = formatRupiah(penghasilanNeto);
        document.querySelectorAll('.res')[1].textContent = formatRupiah(netoUntukPPh);
        document.querySelectorAll('.res')[2].textContent = formatRupiah(ptkp);
        document.querySelectorAll('.res')[3].textContent = formatRupiah(pkp);
        document.querySelectorAll('.res')[4].textContent = tarifDikenakan;
        document.querySelectorAll('.res')[5].textContent = formatRupiah(pph21pkp);
        document.querySelectorAll('.rp-total')[2].textContent = formatRupiah(pph21MasaIni);
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
        document.getElementById("akhir-tahun").textContent = akhirTahunPajak.toLocaleDateString("id-ID", { day: "2-digit", month: "short", year: "numeric" });
        document.getElementById("jatuh-tempo").textContent = jatuhTempo.toLocaleDateString("id-ID", { day: "2-digit", month: "short", year: "numeric" });
        document.getElementById("batas-start").textContent = getCountdown(akhirTahunPajak);
        document.getElementById("batas-end").textContent = getCountdown(jatuhTempo);
    }

    function setupEventListeners() {
        document.querySelectorAll('.rp').forEach(input => {
            input.addEventListener('input', function () {
                let value = this.value.replace(/\D/g, '');
                this.value = value ? 'Rp ' + new Intl.NumberFormat('id-ID').format(value) : '';
            });
        });
        document.querySelectorAll('input, select').forEach(el => {
            el.addEventListener('input', hitung);
            el.addEventListener('change', hitung);
        });

        const startMonthInput = document.getElementById('startMonth');
        const endMonthInput = document.getElementById('endMonth');
        const spdnForm = document.getElementById('spdnForm');
        function checkSPDNVisibility() {
            if (!startMonthInput || !endMonthInput || !spdnForm) return;
            const start = startMonthInput.value;
            const end = endMonthInput.value;
            const isFullYear = start === '2025-01' && end === '2025-12';
            spdnForm.style.display = isFullYear || !start || !end ? 'none' : 'block';
        }
        if(startMonthInput) startMonthInput.addEventListener('change', function () {
            if (startMonthInput.value) {
                endMonthInput.disabled = false;
                endMonthInput.min = startMonthInput.value;
                if (endMonthInput.value && endMonthInput.value < startMonthInput.value) {
                    endMonthInput.value = startMonthInput.value;
                }
            } else {
                endMonthInput.disabled = true;
                endMonthInput.value = "";
            }
            checkSPDNVisibility();
        });
        if(endMonthInput) endMonthInput.addEventListener('change', checkSPDNVisibility);
        checkSPDNVisibility();
    }

    // ▼▼▼ BAGIAN 3: INISIALISASI HALAMAN ▼▼▼

    function initializePage() {
        setupEventListeners();
        calculateTaxDates();

        if (window.pegawaiTetapData) { // Cek jika kita dalam mode edit
            console.log("Mode Edit terdeteksi, data dari server digunakan.");

            // FIX: Blok formatting sekarang HANYA berjalan di dalam mode edit.
            // Ini untuk mengubah angka mentah dari database menjadi format Rupiah.
            document.querySelectorAll('.rp').forEach(input => {
                if (input.value) {
                    input.value = formatRupiah(input.value);
                }
            });

        } else {
            // Jika bukan mode edit, jalankan logika untuk pengguna tamu.
            // Fungsi ini mengisi form dengan data yang sudah diformat dari localStorage.
            loadAndRestoreCalculatorData();
        }

        // Panggil updateDisplay (jika ada) dan hitung SETELAH semua data dimuat.
        // updateDisplay(); // Fungsi ini tidak ada di calculator.js, jadi bisa dihapus jika tercopy.
        hitung();
    }

    initializePage();

    // ▼▼▼ BAGIAN 4: LOGIKA TOMBOL AKSI (STORE & UPDATE) ▼▼▼

    async function handleSubmission(isUpdate = false, isRemindLater = false) {
        const data = getFormData();
        const url = isUpdate ? `/pegawai-tetap/${window.transaksiData.id}` : '/pegawai-tetap/store';
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
                handleSubmission(false, false);
            } else {
                saveCalculatorDataToLocalStorage();
                window.location.href = `/login?redirect_to=${window.location.pathname}`;
            }
        });
    }

    const remindLaterButton = document.getElementById('remind-later');
    if (remindLaterButton) {
        remindLaterButton.addEventListener('click', () => {
            const isLoggedIn = document.body.getAttribute('data-authenticated') === 'true';
            if (isLoggedIn) {
                handleSubmission(false, true);
            } else {
                saveCalculatorDataToLocalStorage();
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
