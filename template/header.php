<header id="navbar" class="bg-primary">
    <nav class="navbar topnavbar">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">
                <img src="/images/logo-header.png" alt="Tras Logo" class="brand-logo">
                <img src="/images/logo-min.png" alt="Tras min Logo" class="brand-logo-collapsed">
            </a>
            <div class="mobile-toggles">
                <a href="#navbar-collapse" data-toggle="collapse" class="menu-toggle">
                    <em class="fa fa-cog"></em>
                </a>
                <a href="#sidebar" data-toggle="collapse" class="sidebar-toggle">
                    <em class="fa fa-navicon"></em>
                </a>
            </div>
        </div>
        <div id="navbar-collapse" class="nav-wrapper navbar-collapse collapse" aria-expanded="false" aria-hidden="true" style="height: 0px;">
            <ul class="nav navbar-nav">
                <li>
                    <a href="#" onclick="sidebarCollapse($(this), false); return false;" class="hidden-xs">
                        <em class="fa fa-caret-left"></em>
                    </a>
                </li>
            </ul>
            <form role="search" method="post" action="/search" id="searchform" autocomplete="off" class="search-form navbar-form navbar-left ng-pristine ng-valid">
                <div class="form-group">
                    <div  class="input-group">
                        <span class="input-group-addon">
                            <em class="icon-search"></em>
                        </span>
                        <input type="text" name="search" <?php if (isset($_POST['search'])) { echo 'value="'.htmlentities($_POST['search']).'"'; } ?> placeholder="Search ..." class="form-control" style="margin-left: 8px;" aria-autocomplete="list" aria-expanded="false" aria-owns="typeahead-46-5595">
                        <?php /*<ul class="dropdown-menu ng-isolate-scope ng-hide" style="display: block;" role="listbox" aria-hidden="true" typeahead-popup="" id="typeahead-46-5595" matches="matches" active="activeIdx" select="select(activeIdx)" move-in-progress="moveInProgress" query="query" position="position">
                        </ul>*/ ?>
                    </div>
                </div>
                <button type="submit" class="hidden btn btn-default">Submit</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
            <?php
            $notifications = Shared::get("notifications");
            ?>
                <li id="notifications-popup" class="dropdown dropdown-list">
                    <a href="#" data-target="#notifications-popup" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false">
                        <div class="point-pin">
                            <em class="icon-mail fa-fw"></em>
                            <div class="label pull-right label-primary"><?php echo Shared::get("notificationsCount") ?></div>
                        </div>
                        <span class="visible-xs-inline ml">View Alerts</span>
                    </a>
                    <?php if (!empty($notifications)) { ?>
                    <ul class="dropdown-menu fadeInLeft2 animated">
                    <?php
                    foreach ($notifications as $n) {
                    ?>
                        <li class="bt<?php echo $n['viewed'] == 1 ? " bg-gray-lighter viewed":""; ?>">
                            <a href="<?php echo $n['link'] ?>" data-notification-id="<?php echo $n['id'] ?>" class="p notification-link">
                                <div class="media">
                                    <div class="pull-left">
                                        <div class="point-pin">
                                            <img src="<?php echo $n['avatar'] ?>" alt="user msg" class="img-responsive thumb32 img-circle">
                                        </div>
                                    </div>
                                    <div class="media-body clearfix">
                                        <p class="notification-title"><?php echo $n['title'] ?></p>
                                        <p class="m0 text-gray text-sm"><?php if (!empty($n['content'])) { echo Shared::removeFormatting($n['content'])." "; } ?><?php echo Shared::elapsedTime($n['when']) ?></p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                        <li class="text-center bt">
                            <a class="p" href="/notifications/">
                                <small>View All</small>
                            </a>
                        </li>
                    </ul>
                    <?php } ?>
                </li>
                <?php /*<li class="visible-lg">
                    <a href="#" toggle-fullscreen="toggle-fullscreen">
                        <em class="fa fa-expand"></em>
                    </a>
                </li>
                <li>
                    <a title="Lock screen" href="/page/lock">
                        <em class="icon-lock fa-fw"></em>
                        <span class="visible-xs-inline ml">Lock Screen</span>
                    </a>
                </li>*/ ?>
            </ul>
        </div>
    </nav>
</header>