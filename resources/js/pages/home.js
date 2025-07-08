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
        const year = now.getFullYear();
        const targetThisYear = new Date(year, 2, 31);
        return now <= targetThisYear ? targetThisYear : new Date(year + 1, 2, 31);
    }

    function updateCountdown() {
        const now = new Date();
        const target = getNextTargetDate();
        let diff = target - now;

        if (diff <= 0) {
            document.getElementById('countdown').innerText = '– Bulan, – Minggu, – Hari';
            return;
        }

        const msInDay = 1000 * 60 * 60 * 24;
        const msInWeek = msInDay * 7;
        const avgDaysInMonth = 30.436875;
        const msInMonth = msInDay * avgDaysInMonth;

        const months = Math.floor(diff / msInMonth);
        diff -= months * msInMonth;

        const weeks = Math.floor(diff / msInWeek);
        diff -= weeks * msInWeek;

        const days = Math.floor(diff / msInDay);

        const parts = [];
        if (months) parts.push(`${months} Bulan`);
        if (weeks) parts.push(`${weeks} Minggu`);
        if (days || parts.length === 0) parts.push(`${days} Hari`);

        document.getElementById('countdown').innerText = parts.join(', ');
    }

    updateCountdown();
    setInterval(updateCountdown, 1000 * 60 * 60);
});
