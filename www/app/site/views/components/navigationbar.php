<div class="bg-white sticky-top shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-light container">
    <a class="navbar-brand" href="/">
         <img src="/logo192.png" width="30" height="30" class="d-inline-block align-top" alt="">
        <?php echo SITE_NAME;?>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <!-- form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        </form-->

        <?php Template::render("navigationbar_left");?>
        <?php Template::render("navigationbar_right");?>
        
        
      
    </div>
    </nav>
</div>