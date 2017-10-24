<?php
use \yii\helpers\Url;
?>
<div class="site-menubar">
    <div class="site-menubar-body">
    <div>
        <div>
        <ul class="site-menu">
            <?php
            if (\Yii::$app->user->can('admin')) {
            ?>
                <li class="site-menu-category">Super admin</li>
                <li class="site-menu-item has-sub">
                    <a href="javascript:void(0)">
                        <i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
                        <span class="site-menu-title">Usuarios</span>
                        <span class="site-menu-arrow"></span>
                    </a>
                    <ul class="site-menu-sub">
                        <li class="site-menu-item">
                        <a class="animsition-link" href="<?=Url::base()?>/super-admin/index">
                            <span class="site-menu-title">Lista de usuarios</span>
                        </a>
                        </li>
                        <li class="site-menu-item">
                        <a class="animsition-link" href="../dashboard/v2.html">
                            <span class="site-menu-title">Roles</span>
                        </a>
                        </li>
                        <li class="site-menu-item">
                        <a class="animsition-link" href="../dashboard/ecommerce.html">
                            <span class="site-menu-title">Permisos</span>
                        </a>
                        </li>
                    </ul>
                </li>
            <?php    
            }
            ?>
            <li class="site-menu-category">General</li>
            <li class="site-menu-item">
                <a class="animsition-link" href="<?=Url::base()?>">
                    <i class="site-menu-icon wb-home" aria-hidden="true"></i>
                    <span class="site-menu-title">Inicio</span>
                </a>
            </li>
            <li class="site-menu-item has-sub">
                <a href="javascript:void(0)">
                    <i class="site-menu-icon wb-users" aria-hidden="true"></i>
                    <span class="site-menu-title">Miembros</span>
                    <span class="site-menu-arrow"></span>
                </a>
                <ul class="site-menu-sub">
                    <li class="site-menu-item">
                        <a class="animsition-link" href="<?=Url::base()?>/site/agregar-miembros">
                            <span class="site-menu-title">Registrar miembros</span>
                        </a>
                    </li>
                    <li class="site-menu-item">
                        <a class="animsition-link" href="../layouts/menu-collapsed-alt.html">
                            <span class="site-menu-title">Identificar miembros</span>
                        </a>
                    </li>
                    <li class="site-menu-item">
                        <a class="animsition-link" href="../layouts/menu-expended.html">
                            <span class="site-menu-title">Miembros</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="site-menu-item has-sub">
                <a href="javascript:void(0)">
                    <i class="site-menu-icon wb-envelope" aria-hidden="true"></i>
                    <span class="site-menu-title">Invitados</span>
                    <span class="site-menu-arrow"></span>
                </a>
                <ul class="site-menu-sub">
                    <li class="site-menu-item">
                        <a class="animsition-link" href="<?=Url::base()?>/site/agregar-invitado">
                            <span class="site-menu-title">Registrar invitado</span>
                        </a>
                    </li>
                    <li class="site-menu-item">
                        <a class="animsition-link" href="../layouts/menu-collapsed-alt.html">
                            <span class="site-menu-title">Invitados</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        </div>
    </div>
    </div>
</div>
<div class="site-gridmenu">
    <div>
    <div>
        <ul>
        <li>
            <a href="../apps/mailbox/mailbox.html">
            <i class="icon wb-envelope"></i>
            <span>Mailbox</span>
            </a>
        </li>
        <li>
            <a href="../apps/mailbox/mailbox.html">
            <i class="icon wb-envelope"></i>
            <span>Mailbox</span>
            </a>
        </li>
        <li>
            <a href="../apps/calendar/calendar.html">
            <i class="icon wb-calendar"></i>
            <span>Calendar</span>
            </a>
        </li>
        <li>
            <a href="../apps/contacts/contacts.html">
            <i class="icon wb-user"></i>
            <span>Contacts</span>
            </a>
        </li>
        <li>
            <a href="../apps/media/overview.html">
            <i class="icon wb-camera"></i>
            <span>Media</span>
            </a>
        </li>
        <li>
            <a href="../apps/documents/categories.html">
            <i class="icon wb-order"></i>
            <span>Documents</span>
            </a>
        </li>
        <li>
            <a href="../apps/projects/projects.html">
            <i class="icon wb-image"></i>
            <span>Project</span>
            </a>
        </li>
        <li>
            <a href="../apps/forum/forum.html">
            <i class="icon wb-chat-group"></i>
            <span>Forum</span>
            </a>
        </li>
        <li>
            <a href="../index.html">
            <i class="icon wb-dashboard"></i>
            <span>Dashboard</span>
            </a>
        </li>
        </ul>
    </div>
    </div>
</div>