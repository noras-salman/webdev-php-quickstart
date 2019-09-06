 
<div class="single-form-wrapper">
    <div class="single-form ">
<form method="post" class="text-center">
  <img class="mb-4" src="/logo512.png" alt="" width="72" height="72">
  <h1 class="h3 mb-5 font-weight-normal">Profile</h1>

  <div class="mt-3 text-left">
    <label>
      Email:  
    </label>
    <label class="float-right  text-right">
        <?php echo SessionManager::getUser()->email;?>
        <br>
        <?php  if(SessionManager::getUser()->email_verified){ ?>
            <div class="text-success">Verified</div> 
        <?php  } else { ?>
           <a href="/email_verification?mode=requestEmailVerification" class="text-danger">Verification required</a> 
        <?php  }?>
    </label>
  </div>

 

  <div class="text-left mt-3">
    <label>Name</label>
    <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo SessionManager::getUser()->db_user->profile->name;?>" required autofocus>
  </div>

 
  <button class="btn btn-lg btn-primary btn-block mt-5 " type="submit" name="update">Update profile</button>
  </form>
 
    <form method="post" class="text-center mt-5">
        <button class="btn btn-lg btn-info btn-block" type="submit" name="reset">Update password</button>
    </form>
  <hr class="mt-5"/>

  <form method="post" class="text-center mt-5">
    <button class="btn btn-lg btn-danger btn-block" type="submit" name="delete">Delete account</button>
   </form>
   </div>
</div>

 
