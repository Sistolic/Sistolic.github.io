var input = document.querySelector('.password');
var img = document.getElementById('show');

document.getElementById('showPassword').addEventListener('click', function() {
  if (input.type == "password") {
    input.type = "text";

    img.src = "../icon/show-regular-24.png";
  } else {
    input.type = "password";

    img.src = "../icon/hide-regular-24.png";
  }
});