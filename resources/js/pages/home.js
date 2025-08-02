document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    let selectedDate = null; // untuk simpan tanggal

    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      selectable: true,
      dateClick: function(info) {
        selectedDate = info.dateStr;
        // opsional: tampilkan highlight atau info tanggal
        console.log("Tanggal dipilih:", selectedDate);
      }
    });

    calendar.render();

    // Saat tombol 'Tambah +' diklik
    document.getElementById('btnTambah').addEventListener('click', function () {
      if (selectedDate) {
        alert('Tanggal yang akan disimpan: ' + selectedDate);

        // TODO: bisa lanjut kirim ke server lewat form hidden / fetch / axios
        // contoh:
        // axios.post('/simpan-pengingat', { tanggal: selectedDate });

      } else {
        alert('Pilih tanggal terlebih dahulu dari kalender!');
      }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    function getNextTargetDate() {
        const now = new Date();
        const currentYear = now.getFullYear();
        const thisYearTarget = new Date(`${currentYear}-03-31`);

        if (now > thisYearTarget) {
            return new Date(`${currentYear + 1}-03-31`);
        } else {
            return thisYearTarget;
        }
}

    function updateCountdown() {
        const now = new Date();
        const target = getNextTargetDate();
        const diffMs = target - now;

        if (diffMs <= 0) {
            document.getElementById('countdown').innerText = 'Waktu Habis';
            return;
        }
        const diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));

        const avgDaysInMonth = 30.44;

        const months = Math.floor(diffDays / avgDaysInMonth);
        const weeks = Math.floor((diffDays % avgDaysInMonth) / 7);
        const days = Math.floor((diffDays % avgDaysInMonth) % 7);
        const parts = [];
        if (months > 0) parts.push(`${months} Bulan`);
        if (weeks > 0) parts.push(`${weeks} Minggu`);
        if (days > 0 || parts.length === 0) parts.push(`${days} Hari`);

        document.getElementById('countdown').innerText = parts.join(', ');
    }
    setInterval(updateCountdown, 1000);
});
