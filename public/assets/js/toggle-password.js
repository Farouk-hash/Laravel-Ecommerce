
    // Toggle for main password field
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      
      if (type === 'text') {
        this.classList.remove('fa-eye');
        this.classList.add('fa-eye-slash');
        this.classList.add('active');
      } else {
        this.classList.remove('fa-eye-slash');
        this.classList.add('fa-eye');
        this.classList.remove('active');
      }
    });

    // Toggle for password confirmation field
    const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
    const passwordConfirmationInput = document.getElementById('password_confirmation');

    togglePasswordConfirmation.addEventListener('click', function() {
      const type = passwordConfirmationInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordConfirmationInput.setAttribute('type', type);
      
      if (type === 'text') {
        this.classList.remove('fa-eye');
        this.classList.add('fa-eye-slash');
        this.classList.add('active');
      } else {
        this.classList.remove('fa-eye-slash');
        this.classList.add('fa-eye');
        this.classList.remove('active');
      }
    });

    // Optional: Hide passwords when clicking outside
    document.addEventListener('click', function(event) {
      if (!event.target.closest('.password-container')) {
        // Reset main password field
        passwordInput.setAttribute('type', 'password');
        togglePassword.classList.remove('fa-eye-slash', 'active');
        togglePassword.classList.add('fa-eye');
        
        // Reset confirmation password field
        passwordConfirmationInput.setAttribute('type', 'password');
        togglePasswordConfirmation.classList.remove('fa-eye-slash', 'active');
        togglePasswordConfirmation.classList.add('fa-eye');
      }
    });
  