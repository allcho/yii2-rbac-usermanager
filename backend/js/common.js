$(document).ready(function () {

    $('body').on('click', '#generate', function (event) {
      var pass = '';
      var strong = 12;
      var simbol = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()';
      
      for(var i = 0; i < strong; i++)
      {
          pass += simbol.charAt(Math.floor(Math.random() * simbol.length));
      }
      document.getElementById('random').value = pass;
    });
});