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

document.addEventListener("DOMContentLoaded", function () {
  const parseRupiah = (str) => parseInt((str || '').replace(/[^\d]/g, '') || '0');
  const formatRupiah = (value) => 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.floor(value || 0));

  const monthNames = [
    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
  ];

  const TERBulanan = {
    A: [
      [5400000, 0], [5650000, 0.0025], [5950000, 0.005], [6300000, 0.0075], [6750000, 0.01], [7500000, 0.0125],
      [8550000, 0.015], [9650000, 0.0175], [10950000, 0.02], [10350000, 0.0225], [10700000, 0.025],
      [11050000, 0.03], [11500000, 0.035], [12500000, 0.04], [13750000, 0.05], [15100000, 0.06],
      [16590000, 0.07], [19750000, 0.08], [21450000, 0.09], [26450000, 0.1], [28000000, 0.11],
      [30500000, 0.12], [32400000, 0.13], [35400000, 0.14], [39100000, 0.15], [43850000, 0.16],
      [47800000, 0.17], [51400000, 0.18], [56500000, 0.19], [62200000, 0.2], [68600000, 0.21],
      [77500000, 0.22], [89000000, 0.23], [103000000, 0.24], [125000000, 0.25], [157000000, 0.26],
      [206000000, 0.27], [337000000, 0.28], [454000000, 0.29], [550000000, 0.3], [695000000, 0.31],
      [910000000, 0.32], [1400000000, 0.33], [Infinity, 0.34]
    ],
    B: [
      [6200000, 0], [6500000, 0.0025], [6850000, 0.005], [7300000, 0.0075], [7900000, 0.01],
      [8750000, 0.0125], [10750000, 0.015], [11250000, 0.02], [11600000, 0.03], [12600000, 0.04],
      [13600000, 0.05], [14950000, 0.06], [16400000, 0.07], [18450000, 0.08], [21850000, 0.09],
      [26000000, 0.1], [27700000, 0.11], [29350000, 0.12], [33500000, 0.13], [37000000, 0.14],
      [41000000, 0.15], [45800000, 0.16], [49500000, 0.17], [53800000, 0.18], [58500000, 0.19],
      [64000000, 0.2], [71000000, 0.21], [80000000, 0.22], [93000000, 0.23], [109000000, 0.24],
      [134000000, 0.25], [169000000, 0.26], [221000000, 0.27], [374000000, 0.28], [459000000, 0.29],
      [555000000, 0.3], [704000000, 0.31], [957000000, 0.32], [1405000000, 0.33], [Infinity, 0.34]
    ],
    C: [
      [6600000, 0], [6950000, 0.0025], [7350000, 0.005], [7800000, 0.0075], [8850000, 0.0125],
      [9900000, 0.015], [10950000, 0.0175], [11200000, 0.02], [12950000, 0.03], [14150000, 0.04],
      [15550000, 0.05], [17050000, 0.06], [19500000, 0.07], [22700000, 0.08], [26600000, 0.09],
      [28000000, 0.1], [30100000, 0.11], [32100000, 0.12], [35400000, 0.13], [38900000, 0.14],
      [43000000, 0.15], [47400000, 0.16], [51800000, 0.17], [56600000, 0.18], [62500000, 0.19],
      [66700000, 0.2], [74500000, 0.21], [83200000, 0.22], [95600000, 0.23], [110000000, 0.24],
      [134000000, 0.25], [169000000, 0.26], [221000000, 0.27], [390000000, 0.28], [463000000, 0.29],
      [561000000, 0.3], [709000000, 0.31], [965000000, 0.32], [1419000000, 0.33], [Infinity, 0.34]
    ]
  };

  function getTERKategori(gender, kawin, tanggungan) {
    if (gender === '1' && kawin === '0') return 'A'; // wanita kawin = TK/0
    if (kawin === '0' && tanggungan <= 1) return 'A';
    if (kawin === '0' && tanggungan >= 2) return 'B';
    if (kawin === '1' && tanggungan === 0) return 'A';
    if (kawin === '1' && tanggungan <= 2) return 'B';
    if (kawin === '1' && tanggungan === 3) return 'C';
    return 'A';
  }

  function getTERTarif(kategori, bruto) {
    for (let [batas, tarif] of TERBulanan[kategori]) {
      if (bruto <= batas) return tarif;
    }
    return 0.05;
  }

  function getTarifPasal17(pkp) {
  if (pkp <= 60000000) return 0.05;
  if (pkp <= 250000000) return 0.15;
  if (pkp <= 500000000) return 0.25;
  if (pkp <= 5000000000) return 0.30;
  return 0.35;
}


  function hitung() {
    const gender = document.querySelector('input[name="sex"]:checked')?.value || '0';
    const kawin = document.getElementById('floatingSelect').value;
    const tanggungan = parseInt(document.getElementById('jmlTanggungan').value || '0');
    const kategori = getTERKategori(gender, kawin, tanggungan);

    const isBulanan = document.getElementById('dibayar-ya').checked;
    const isSama = document.getElementById('sama').checked;
    const isBeda = document.getElementById('tidakSama').checked;

    let total = 0;
    let pphTotal = 0;

    // Bersihkan hasil sebelumnya jika bulanan beda
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
        const key = bulan.toLowerCase().slice(0, 3); // contoh: januari => jan
        wrapper.classList.add('res-field', 'bulanPajak');
        wrapper.innerHTML = `<p class="label">${bulan}</p><p id="pajak-${key}" class="res pphBulan">${formatRupiah(pph)}</p>`;
        bulananBedaWrap.appendChild(wrapper);
      });

    } else {
        const bruto = parseRupiah(document.getElementById('brutoProyek').value);
        const hari = parseInt(document.getElementById('lamaKerja').value || '0');
        const rata = bruto / hari;
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
        document.getElementById('pphRataHari').textContent = formatRupiah(pph / hari);
      }

    document.getElementById('rp-total').textContent = formatRupiah(pphTotal);
  }

  document.querySelectorAll('input, select').forEach(el => {
    el.addEventListener('input', hitung);
    el.addEventListener('change', hitung);
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

document.getElementById('pay-now').addEventListener('click', async function () {
    const isLoggedIn = document.body.getAttribute('data-authenticated') === 'true';

    if (!isLoggedIn) {
        sessionStorage.setItem('redirect_after_login', window.location.pathname);
        window.location.href = '/login';
        return;
    }

    const parseRupiah = (str) => parseInt((str || '').replace(/[^\d]/g, '') || '0');

    const isBulanan = document.querySelector('input[name="dibayar_bulanan"]:checked')?.value === "0";
    const isSama = document.querySelector('input#sama')?.checked;
    const isBeda = document.querySelector('input#tidakSama')?.checked;

    const gender = document.querySelector('input[name="sex"]:checked')?.value;
    const kawin = document.getElementById('floatingSelect')?.value;
    const tanggungan = parseInt(document.getElementById('jmlTanggungan')?.value);

    const bulanMap = {
        Januari: 'jan', Februari: 'feb', Maret: 'mar', April: 'apr',
        Mei: 'mei', Juni: 'jun', Juli: 'jul', Agustus: 'agu',
        September: 'sep', Oktober: 'okt', November: 'nov', Desember: 'des'
    };

    

    const data = {
        jenis_kelamin: gender,
        status_perkawinan: kawin,
        tanggungan: tanggungan,
        dibayar_bulanan: isBulanan ? 1 : 0,
        bulanan_sama: isSama ? 1 : 0,
        // metode_penghitungan: document.getElementById('metodeHitungSama')?.textContent || document.getElementById('metodeHitungBeda')?.textContent || document.getElementById('metodeHitungTidakBulan')?.textContent || '-',
        pph21_terutang: parseRupiah(document.getElementById('rp-total')?.textContent || '0')
    };
    if (isBulanan) {
      data.bulanan_sama = isSama ? 1 : 0;

      if (isSama) {
          data.metode_penghitungan = document.getElementById('metodeHitungSama')?.textContent || '-';
      } else if (isBeda) {
          data.metode_penghitungan = document.getElementById('metodeHitungBeda')?.textContent || '-';
      }
  } else {
      data.metode_penghitungan = document.getElementById('metodeHitungTidakBulan')?.textContent || '-';
  }


    if (isBulanan && isSama) {
        data.bruto_perbulan = parseRupiah(document.getElementById('brutoBulanan').value);
        data.banyak_bulan_bekerja = parseInt(document.getElementById('jmlBulan').value || '0');
        data.pph21_perbulan = parseRupiah(document.getElementById('pphRataSama')?.textContent || '0');
    }

    if (isBulanan && isBeda) {
        Object.entries(bulanMap).forEach(([bulan, key]) => {
            data[`bruto_${key}`] = parseRupiah(document.getElementById(bulan)?.value || '0');
            const pajakElem = document.getElementById(`pajak-${key}`);
            data[`pajak_${key}`] = pajakElem ? parseRupiah(pajakElem.textContent || '0') : 0;
        });
    }

    if (!isBulanan) {
        data.total_bruto = parseRupiah(document.getElementById('brutoProyek').value);
        data.lama_hari_bekerja = parseInt(document.getElementById('lamaKerja').value || '0');
        data.avg_bruto = parseRupiah(document.getElementById('avBruto')?.textContent || '0');
        data.pph21_perhari = parseRupiah(document.getElementById('pphRataHari')?.textContent || '0');
    }
    console.log("Data yang dikirim:", data);


    fetch('/pegawai-tidak-tetap/store', {
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
            const res = await response.json();
            alert('Data berhasil disimpan!');
        }
    })
    .catch(err => {
        console.error('Network error:', err);
    });
});
document.getElementById('remind-later').addEventListener('click', async function () {
    const isLoggedIn = document.body.getAttribute('data-authenticated') === 'true';

    if (!isLoggedIn) {
        sessionStorage.setItem('redirect_after_login', window.location.pathname);
        window.location.href = '/login';
        return;
    }

    const parseRupiah = (str) => parseInt((str || '').replace(/[^\d]/g, '') || '0');

    const isBulanan = document.querySelector('input[name="dibayar_bulanan"]:checked')?.value === "0";
    const isSama = document.querySelector('input#sama')?.checked;
    const isBeda = document.querySelector('input#tidakSama')?.checked;

    const gender = document.querySelector('input[name="sex"]:checked')?.value;
    const kawin = document.getElementById('floatingSelect')?.value;
    const tanggungan = parseInt(document.getElementById('jmlTanggungan')?.value);

    const bulanMap = {
        Januari: 'jan', Februari: 'feb', Maret: 'mar', April: 'apr',
        Mei: 'mei', Juni: 'jun', Juli: 'jul', Agustus: 'agu',
        September: 'sep', Oktober: 'okt', November: 'nov', Desember: 'des'
    };

    

    const data = {
        jenis_kelamin: gender,
        status_perkawinan: kawin,
        tanggungan: tanggungan,
        dibayar_bulanan: isBulanan ? 1 : 0,
        bulanan_sama: isSama ? 1 : 0,
        // metode_penghitungan: document.getElementById('metodeHitungSama')?.textContent || document.getElementById('metodeHitungBeda')?.textContent || document.getElementById('metodeHitungTidakBulan')?.textContent || '-',
        pph21_terutang: parseRupiah(document.getElementById('rp-total')?.textContent || '0')
    };
    if (isBulanan) {
      data.bulanan_sama = isSama ? 1 : 0;

      if (isSama) {
          data.metode_penghitungan = document.getElementById('metodeHitungSama')?.textContent || '-';
      } else if (isBeda) {
          data.metode_penghitungan = document.getElementById('metodeHitungBeda')?.textContent || '-';
      }
  } else {
      data.metode_penghitungan = document.getElementById('metodeHitungTidakBulan')?.textContent || '-';
  }


    if (isBulanan && isSama) {
        data.bruto_perbulan = parseRupiah(document.getElementById('brutoBulanan').value);
        data.banyak_bulan_bekerja = parseInt(document.getElementById('jmlBulan').value || '0');
        data.pph21_perbulan = parseRupiah(document.getElementById('pphRataSama')?.textContent || '0');
    }

    if (isBulanan && isBeda) {
        Object.entries(bulanMap).forEach(([bulan, key]) => {
            data[`bruto_${key}`] = parseRupiah(document.getElementById(bulan)?.value || '0');
            const pajakElem = document.getElementById(`pajak-${key}`);
            data[`pajak_${key}`] = pajakElem ? parseRupiah(pajakElem.textContent || '0') : 0;
        });
    }

    if (!isBulanan) {
        data.total_bruto = parseRupiah(document.getElementById('brutoProyek').value);
        data.lama_hari_bekerja = parseInt(document.getElementById('lamaKerja').value || '0');
        data.avg_bruto = parseRupiah(document.getElementById('avBruto')?.textContent || '0');
        data.pph21_perhari = parseRupiah(document.getElementById('pphRataHari')?.textContent || '0');
    }
    console.log("Data yang dikirim:", data);


    fetch('/pegawai-tidak-tetap/store', {
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
            const res = await response.json();
            alert('Data berhasil disimpan!');
        }
    })
    .catch(err => {
        console.error('Network error:', err);
    });
});
