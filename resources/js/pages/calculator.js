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

// Kalkulasi PPh 21 Pegawai Tetap

// Kalkulasi PPh 21 Pegawai Tetap

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
    if (statusKawin === '0' && gender === '0') ptkp += 4500000; // hanya pria kawin dapat tambahan K/0
    ptkp += Math.min(3, tanggungan) * 4500000;

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
  }

  function formatRupiah(value) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
  }

  document.querySelectorAll('input, select').forEach(input => {
    input.addEventListener('change', hitung);
    input.addEventListener('input', hitung);
  });
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