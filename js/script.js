function autofill(fnameId, lnameId, fullnameId) {
  const fname = document.getElementById(fnameId).value;
  const lname = document.getElementById(lnameId).value;
  const fullname = fname + ' ' + lname;
  document.getElementById(fullnameId).value = fullname;
}
