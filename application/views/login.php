<link href="<?php echo base_url('assets/bootstrap-5.0.2-dist/css/bootstrap.css');?>" rel="stylesheet"  crossorigin="anonymous">

<div class="container-fluid">
  <div class="row no-gutter">
    <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
    <div class="col-md-8 col-lg-6">
      <div class="login d-flex align-items-center py-5">
        <div class="container">
          <div class="row">
            <div class="col-md-9 col-lg-8 mx-auto">
              <h3 class="login-heading mb-4"> <b>De-Dons Pub POS</b></h3>

              <?php echo validation_errors(); ?>  

                <?php if(!empty($errors)) {
                  echo $errors;
                } ?>
                <br>
              <form action="<?php echo base_url('auth/login') ?>" method="post" class="row g-3">
              <div class="col-md-12">
              <div class="form-group">
                <label for="username" class="form-label">Username</label>
                  <input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
                </div>
              </div>
                
              <div class="col-md-12">
              <div class="form-group">
                <label for="password" class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" placeholder="Password" required >
                </div>
              </div>
                
                <br>

                  <div class="col-md-12">
                  <button class="btn btn-lg btn-primary btn-block font-weight-bold mb-2" type="submit">Sign in</button>
</div>

              
                  <!-- <a class="small" href="#">Forgot password?</a></div> -->
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<style>
:root {
  --input-padding-x: 1.5rem;
  --input-padding-y: 0.75rem;
}

a,
a:link,
a:hover {
  text-decoration: none;
}

.login,
.image {
  min-height: 100vh;
}

.bg-image {
  background-image: url('<?php echo base_url('assets/images/wine-store.jpg') ?>');
  background-size: cover;
  background-position: center;
}

.login-heading {
  font-weight: 300;
}

/* .btn-login {
  font-size: 0.9rem;
  letter-spacing: 0.05rem;
  padding: 0.75rem 1rem;
  border-radius: 2rem;
} */

/* .form-label-group {
  position: relative;
  margin-bottom: 1rem;
} */

/* .form-label-group>input,
.form-label-group>label {
  padding: var(--input-padding-y) var(--input-padding-x);
  height: auto;
  border-radius: 2rem;
} */

/* .form-label-group>label {
  position: relative;
  top: 0;
  left: 0;
  display: block;
  width: 100%;
  margin-bottom: 0;
  /* Override default `<label>` margin */
  /* line-height: 1.5;
  color: #495057;
  cursor: text;
  /* Match the input under the label */
  /* border: 1px solid transparent;
  border-radius: .25rem; */
  transition: all .1s ease-in-out; */
} */

.form-label-group input::-webkit-input-placeholder {
  color: transparent;
}

.form-label-group input:-ms-input-placeholder {
  color: transparent;
}

.form-label-group input::-ms-input-placeholder {
  color: transparent;
}

.form-label-group input::-moz-placeholder {
  color: transparent;
}

.form-label-group input::placeholder {
  color: transparent;
}

.form-label-group input:not(:placeholder-shown) {
  padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
  padding-bottom: calc(var(--input-padding-y) / 3);
}

.form-label-group input:not(:placeholder-shown)~label {
  padding-top: calc(var(--input-padding-y) / 3);
  padding-bottom: calc(var(--input-padding-y) / 3);
  font-size: 12px;
  color: #777;
}

/* Fallback for Edge
-------------------------------------------------- */

@supports (-ms-ime-align: auto) {
  .form-label-group>label {
    display: none;
  }
  .form-label-group input::-ms-input-placeholder {
    color: #777;
  }
}

/* Fallback for IE
-------------------------------------------------- */

@media all and (-ms-high-contrast: none),
(-ms-high-contrast: active) {
  .form-label-group>label {
    display: none;
  }
  .form-label-group input:-ms-input-placeholder {
    color: #777;
  }
}

</style>