function openMethod(MethodName) {
  var i;
  var x = document.getElementsByClassName("method");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  document.getElementById(MethodName).style.display = "block";
}
