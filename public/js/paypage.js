function openMethod(MethodName) {
  var i;
  var x = document.getElementsByClassName("method");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  document.getElementById(MethodName).style.display = "block";
}

const form = document.getElementById('dataNPWP');

form.addEventListener('submit', function(event){
    event.preventDefault();

    const npwp = document.getElementById('NPWP').value;

    const hasil = document.getElementById('outputNPWP').textContent = npwp;

})
