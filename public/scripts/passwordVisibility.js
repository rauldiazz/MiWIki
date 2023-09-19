function togglePasswordVisibility(passwordFieldId) {
    var passwordField = document.getElementById(passwordFieldId);
    var passwordToggleBtn = document.getElementById(passwordFieldId + 'ToggleBtn');

    if (passwordField.type === 'password') {
      passwordField.type = 'text';
      passwordToggleBtn.innerHTML = '<i class="bi bi-eye-slash"></i>';
    } else {
      passwordField.type = 'password';
      passwordToggleBtn.innerHTML = '<i class="bi bi-eye"></i>';
    }
  }