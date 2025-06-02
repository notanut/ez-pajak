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

// let gajiBersih = document.getElementById('gaji').value.replace(/\D/g, '');


// belum bisa
document.addEventListener("DOMContentLoaded", function () {
  const start = document.getElementById("startMonth");
  const end = document.getElementById("endMonth");

  if (!start || !end) return;

  start.addEventListener("change", function () {
    if (start.value) {
      document.getElementById("endMonth").min = document.getElementById("startMonth").value;
      if (end.value && end.value < start.value) {
        end.value = start.value;
      }
    }
  });

  if (start.value) {
    end.min = start.value;
  }
});

