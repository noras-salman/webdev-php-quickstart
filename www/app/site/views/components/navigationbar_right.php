<ul class="navbar-nav float-right">

<?php if(SessionManager::userAvailable()){ ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo SessionManager::getUser()->email; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                
            <?php if(!SessionManager::getUser()->email_verified){ ?>
                <a class="dropdown-item text-danger" href="/email_verification?mode=requestEmailVerification">Verify email</a>
            <?php } ?>

            
                <a class="dropdown-item" href="/profile">Profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/logout">Logout</a>
                </div>
            </li>

        <?php } else { ?>

            <li class="nav-item">
            <?php 
            Template::render("href_button",array(
                "href"=>"/login",
                "class"=>"btn-outline-secondary rounded-pill",
                "text"=>getText("login") 
                ));
             ?>
          
            </li>
            <li class="nav-item ml-3">

            <?php 
                Template::render("href_button",array(
                    "href"=>"/register",
                    "class"=>"btn-outline-primary rounded-pill",
                    "text"=>getText("register") 
                    ));
             ?>
          
            </li>
        
            <?php } ?>
     
</ul>