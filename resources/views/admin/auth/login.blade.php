<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('admin/assets/css/custom-login.css') }}">
</head>

<body>

  <div class="login-wrap">

    <!-- Left decorative panel -->
    <div class="panel-left">
      <div class="deco deco-1"></div>
      <div class="deco deco-2"></div>
      <div class="deco deco-3"></div>

      <div class="brand">
        <div class="brand-icon">
          <svg viewBox="0 0 16 16">
            <path d="M8 1L2 4v4c0 3.31 2.56 6.41 6 7 3.44-.59 6-3.69 6-7V4L8 1z" />
          </svg>
        </div>
        {{-- <span class="brand-name">Servicool</span> --}}
      </div>

      {{-- <div class="panel-left-content">
        <p class="panel-headline">Your workspace,<br /><em>beautifully</em><br />organised.</p>
        <p class="panel-sub">Everything your team needs in one calm, focused place.</p>
        <div class="stats">
          <div class="stat-pill"><strong>12k+</strong> teams</div>
          <div class="stat-pill"><strong>99.9%</strong> uptime</div>
        </div>
      </div> --}}
    </div>

    <!-- Right login panel -->
    <div class="panel-right">
      <p class="form-eyebrow">Welcome back</p>
      <h1 class="form-title">Sign in</h1>
      <p class="form-desc">Enter your credentials to access your account.</p>

<form method="POST" action="{{ route('admin.login.submit') }}" id="loginForm">
        @csrf
        <!-- Email -->
        <div class="field" id="emailField">
          <label for="email">Email address</label>
          <div class="field-wrap">
            <input type="email" id="email" name="email" placeholder="you@company.com" autocomplete="email" />
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
              <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
            </svg>
          </div>
          <div class="field-error" id="emailError">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd" />
            </svg>
            <span>Please enter a valid email address.</span>
          </div>
        </div>

        <!-- Password -->
        <div class="field" id="passField">
          <label for="password">Password</label>
          <div class="field-wrap has-toggle">
            <input type="password" id="password" name="password" placeholder="••••••••"
              autocomplete="current-password" />
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                clip-rule="evenodd" />
            </svg>
            <button type="button" class="eye-btn" id="eyeBtn" aria-label="Toggle password visibility">
              <!-- Eye icon -->
              <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                <path fill-rule="evenodd"
                  d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                  clip-rule="evenodd" />
              </svg>
            </button>
          </div>
          <div class="field-error" id="passError">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd" />
            </svg>
            <span>Password must be at least 6 characters.</span>
          </div>
        </div>

        <!-- Remember + Forgot -->
        <div class="field-meta">
          <label class="remember">
            <input type="checkbox" id="remember" />
            <span class="check-box">
              <svg viewBox="0 0 10 10">
                <polyline points="1.5,5 4,7.5 8.5,2.5" />
              </svg>
            </span>
            Keep me signed in
          </label>
          <a href="#" class="forgot">Forgot password?</a>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-submit" id="submitBtn">Sign in</button>

      </form>

      <!-- Divider -->
      {{-- <div class="divider">or continue with</div> --}}

    </div>
  </div>

  <!-- Toast -->
  <div class="toast" id="toast">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
      <path fill-rule="evenodd"
        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
        clip-rule="evenodd" />
    </svg>
    Signed in successfully!
  </div>

  <script>
    /* ── Password toggle ── */
    const pwInput = document.getElementById('password');
    document.getElementById('eyeBtn').addEventListener('click', () => {
      const show = pwInput.type === 'password';
      pwInput.type = show ? 'text' : 'password';
      document.getElementById('eyeIcon').innerHTML = show
        ? `<path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"/>
         <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"/>`
        : `<path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
         <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>`;
    });

    /* ── Ripple ── */
    document.getElementById('submitBtn').addEventListener('click', function (e) {
      const r = document.createElement('span');
      const d = Math.max(this.clientWidth, this.clientHeight);
      const rect = this.getBoundingClientRect();
      r.className = 'ripple';
      r.style.cssText = `width:${d}px;height:${d}px;left:${e.clientX - rect.left - d / 2}px;top:${e.clientY - rect.top - d / 2}px`;
      this.appendChild(r);
      setTimeout(() => r.remove(), 600);
    });

    /* ── Validation & submit ── */
document.getElementById('loginForm').addEventListener('submit', function (e) {

  let valid = true;

  const email = document.getElementById('email');
  const emailErr = document.getElementById('emailError');
  const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  if (!emailRe.test(email.value.trim())) {
    email.classList.add('error');
    emailErr.classList.add('visible');
    valid = false;
  } else {
    email.classList.remove('error');
    emailErr.classList.remove('visible');
  }

  const pass = document.getElementById('password');
  const passErr = document.getElementById('passError');

  if (pass.value.length < 6) {
    pass.classList.add('error');
    passErr.classList.add('visible');
    valid = false;
  } else {
    pass.classList.remove('error');
    passErr.classList.remove('visible');
  }

  // ❌ Stop form if invalid
  if (!valid) {
    e.preventDefault();
    return;
  }

  // ✅ Allow form submit (Laravel will handle)
  const btn = document.getElementById('submitBtn');
  btn.textContent = 'Signing in…';
  btn.disabled = true;

});
    /* ── Clear errors on input ── */
    ['email', 'password'].forEach(id => {
      document.getElementById(id).addEventListener('input', function () {
        this.classList.remove('error');
        document.getElementById(id === 'email' ? 'emailError' : 'passError').classList.remove('visible');
      });
    });

  </script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
@if(session('error'))
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'error',
    title: "{{ session('error') }}",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
});
@endif
</script>
</body>

</html>