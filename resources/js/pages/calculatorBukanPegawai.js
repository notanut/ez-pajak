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