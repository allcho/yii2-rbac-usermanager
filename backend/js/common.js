$(document).ready(function () {

    $('body').on('click', '#generate', function (event) {
      let pass = '';
      let strong = 12;
      let simbol = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()';
      
      for(let i = 0; i < strong; i++)
      {
          pass += simbol.charAt(Math.floor(Math.random() * simbol.length));
      }
      document.getElementById('random').value = pass;
    });
});