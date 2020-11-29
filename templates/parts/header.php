
<section class="pt-5 pb-5 mt-0 align-items-center d-flex bg-dark" style="height:60vh; background-size: cover; background-image: url(https://patisserieduparcq.fr/wp-content/uploads/2015/07/gateaux-header.jpg);">

   <div class="container-fluid">
      <div class="row  justify-content-center align-items-center d-flex text-center h-100">
        <div class="col-12 col-md-8  h-50 ">
            <h1 class="display-2  text-light mb-2 mt-5"><strong>PRESTIGEPATISS</strong> </h1>
            <p class="lead  text-light mb-5">La gourmandise jefkjaekzjfklzjka</p>

            <?php
              if  ( isset($_SESSION['connected']) || isset($_SESSION['personnal']) ){ ?>
<p><a href="?action=logout" class="btn bg-danger shadow-lg btn-round text-light btn-lg btn-rised">Se déconnecter </a></p>
      <?php }
      else { ?>
        <p><a href="?action=pageLogin" class="btn bg-danger shadow-lg btn-round text-light btn-lg btn-rised">Se connecter </a></p>
      <?php } ?>

					<div class="btn-container-wrapper p-relative d-block  zindex-1">
						<a class="btn btn-link btn-lg   mt-md-3 mb-4 scroll align-self-center text-light" href="http://bootstraptor.com">
						    <i class="fa fa-angle-down fa-4x text-light"></i>
						    </a>
					</div>
        </div>

      </div>
    </div>
    </section>
