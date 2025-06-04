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

    yaRadio.addEventListener('change', function () {
        if (yaRadio.checked) {
            yaBulanan.style.display = 'block'
            tidakBulanan.style.display = 'none'

            samaBulan.addEventListener('change', function () {
                tiapSama.style.display = 'block'
                tiapBeda.style.display = 'none'
            })
            
            bedaBulan.addEventListener('change', function () {
                tiapBeda.style.display = 'block'
                tiapSama.style.display = 'none'
            })
        }
    });
    
    tidakRadio.addEventListener('change', function () {
        if (tidakRadio.checked) {
            yaBulanan.style.display = 'none'
            tidakBulanan.style.display = 'block'
        }
    });