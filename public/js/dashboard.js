$(document).ready(function () {
  // setTimeout(() => {
  //   const box = document.getElementById('success');

  //   box.style.display = 'none';

  //   // 👇️ hides element (still takes up space on page)
  //   // box.style.visibility = 'hidden';
  // }, 5000); // 👈️
  $('#import').submit(function (event) {
    event.preventDefault();
    // $('#msg').html('');
    // $('#msg').hide();
    const fileInput = document.getElementById('formFile');
    if (fileInput.value) {
      console.log('can import');
    } else {
      $('#msg').removeAttr('hidden');
      $('#msg').show();
      $('#msg').html('Please select file to import');
      // alert('Cant import');
      return false;
    }
    
    this.submit();
  });
});