<?php
use \yii\helpers\Url;
use app\modules\ModUsuarios\models\EntUsuarios;
$usuario = Yii::$app->user->identity;

if(!$usuario){
  $usuario = new EntUsuarios();
}

?>
<nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation">


  <div class="navbar-header">
    <button type="button" class="navbar-toggle hamburger hamburger-close navbar-toggle-left hided unfolded" data-toggle="menubar">
      <span class="sr-only">Toggle navigation</span>
      <span class="hamburger-bar"></span>
    </button>
    <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
      <img class="navbar-brand-logo" src="../assets/images/logo.png" title="Remark">
      <span class="navbar-brand-text"> Remark</span>
    </div>
  </div>

    <div class="navbar-container container-fluid">
      <!-- Navbar Collapse -->
      <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
        <!-- Navbar Toolbar -->
        <ul class="nav navbar-toolbar">
          <li class="hidden-float" id="toggleMenubar">
            <a data-toggle="menubar" href="#" role="button">
              <i class="icon hamburger hamburger-arrow-left">
                  <span class="sr-only">Toggle menubar</span>
                  <span class="hamburger-bar"></span>
                </i>
            </a>
          </li>
          <li class="hidden-xs" id="toggleFullscreen">
            <a class="icon icon-fullscreen" data-toggle="fullscreen" href="#" role="button">
              <span class="sr-only">Toggle fullscreen</span>
            </a>
          </li>
        </ul>
        <!-- End Navbar Toolbar -->
        <!-- Navbar Toolbar Right -->
        <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
        <?php
              if(!Yii::$app->user->isGuest){
              ?>
          <li class="dropdown">
          
            <a class="navbar-avatar dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"
            data-animation="scale-up" role="button">
              <span class="avatar avatar-online">
              
                <img src="<?=$usuario->imageProfile?>" alt="<?=$usuario->nombreCompleto?>">
                
                <i></i>
              </span>
            </a>
            <ul class="dropdown-menu" role="menu">
              <li role="presentation">
                <a href="<?=Url::base()."/profile"?>" role="menuitem"><i class="icon wb-user" aria-hidden="true"></i> Perfil</a>
              </li>
              <li class="divider" role="presentation"></li>
              <li role="presentation">
                <a href="<?=Url::base()."/site/logout"?>" role="menuitem"><i class="icon wb-power" aria-hidden="true"></i> Cerrar sesión</a>
              </li>
            </ul>
          </li>
          <?php 
              }
                ?> 
          
        </ul>
        <!-- End Navbar Toolbar Right -->
      </div>
      <!-- End Navbar Collapse -->
    </div>
  </nav>