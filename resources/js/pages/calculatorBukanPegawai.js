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