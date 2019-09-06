 
<div class="single-form-wrapper">
<form method="post" class="single-form text-center">
  <img class="mb-4" src="/logo512.png" alt="" width="72" height="72">
  <h1 class="h3 mb-3 font-weight-normal">Please login </h1>
  <label for="inputEmail" class="sr-only">Email address</label>
  <input type="email" id="inputEmail" name="email" class="form-control" 
   placeholder="Email address" required autofocus oninvalid="this.setCustomValidity('<?php echo $_TEXT["reqired_field"] ;?>')">
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
  <div class="checkbox mb-3 text-left">
    <label>
      <input type="checkbox" value="remember-me"> Remember me
    </label>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
  <div class="mt-3 text-left">
    <label>
      <a href="/password_reset">Forgot password</a>   
    </label>
    <label class="float-right">
  <a class="right" href="/register">Create an account</a>
    </label>
  </div>
   
</form>

</div>

 
