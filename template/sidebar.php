<aside id="sidebar" class="bg-primary br collapsed">
    <div class="sidebar-wrapper">
        <nav class="sidebar">
            <div class="sidebar-nav">
                <div class="sidebar-buttons">
                <?php if (isLoggedIn()) { ?>
                    <a href="/user/<?php echo Shared::get("nickname") ?>/">
                        <img class="mb center-block img-circle img-responsive thumb64" src="<?php echo Shared::get("avatar") ?>">
                        <div class="text-center">
                            <h4 class="text-bold m0"><?php echo Shared::get("nickname") ?></h4>
                            <small><?php echo Shared::get("friends") ?></small>
                        </div>
                    </a>
                <?php } else { ?>
                        <img class="mb center-block img-circle img-responsive thumb64" src="<?php echo Shared::get("avatar") ?>">
                        <div class="text-center">
                            <h4 class="text-bold m0"><?php echo Shared::get("nickname") ?></h4>
                        </div>
                <?php } ?>
                    <?php /*<div class="text-center">
                        <div class="text-muted mt-sm clearfix">
                            <a href="#" compile="t/views/partials/contacts.html" class="text-sm btn-sidebar pull-left">
                                <em class="icon-speech-bubble fa-fw"></em>
                            </a>
                            <a href="#" compile="t/views/partials/settings.html" class="text-sm btn-sidebar pull-right">
                                <em class="icon-cog fa-fw"></em>
                            </a>
                        </div>
                    </div>*/ ?>
                </div>
                <ul class="nav">
                    <hr class="hidden-collapsed">
                    <li class="nav-heading">
                        <span class="text-muted">Navigation</span>
                    </li>
                    <?php
                    $active = array("home" => "", "account" => "", "friends" => "", "messages" => "");
                    $a = " class=\" active\"";
                    switch (Shared::get("pagename")) {
                        case 'account':
                        case 'notifications':
                        case 'settings':
                            $active['account'] = $a;
                            break;
                        case 'friends':
                            $active['friends'] = $a;
                            break;
                        case 'messages':
                            $active['messages'] = $a;
                            break;
                        default:
                            $active['home'] = $a;
                    }
                    ?>
                    <li<?php echo $active['home'] ?>>
                        <a title="Home" href="/home/"><em class="sidebar-item-icon icon-menu"></em><div class="label pull-right label-info"></div><span>Home</span></a>
                    </li>
                    <li>
                        <hr>
                    </li>
                    <?php if (isLoggedIn()) { ?>
                    <li<?php echo $active['messages'] ?>>
                        <a title="Messages" href="/messages/"><em class="sidebar-item-icon icon-speech-bubble"></em><div class="label pull-right label-info"></div><span>Messages</span></a>
                    </li>
                    <?php } ?>
                    <li<?php echo $active['account'] ?>>
                        <a title="Account" href="#account-collapse" data-toggle="collapse"><em class="sidebar-item-icon icon-head"></em><em class="sidebar-item-caret fa pull-right fa-angle-right"></em><span>Account</span></a>
                        <ul id="account-collapse" class="nav sidebar-subnav collapse" style="height: 0px;">
                            <li class="sidebar-subnav-header"><a><em class="sidebar-item-icon fa fa-angle-left"></em>Account</a>
                            </li>
                            <?php if (isLoggedIn()) { ?>
                            <li>
                                <a title="Settings" href="/settings/basic/"><em class="sidebar-item-icon"></em><span>Settings</span></a>
                            </li>
                            <li>
                                <a title="Logout" href="/page/logout/"><em class="sidebar-item-icon"></em><span>Logout</span></a>
                            </li>
                            <li>
                                <hr>
                            </li>
                            <li>
                                <a title="Notifications" href="/notifications/"><em class="sidebar-item-icon"></em><div class="label pull-right label-primary"><?php echo Shared::get("notificationsCount") ?></div><span>Notifications</span></a>
                            </li>
                            <?php } else { ?>
                            <li>
                                <a title="Login" href="/page/login/"><em class="sidebar-item-icon"></em><span>Login</span></a>
                            </li>
                            <?php } /*<li>
                                <a title="Messages" href="/messages"><em class="sidebar-item-icon"></em><div class="label pull-right label-primary">7</div><span>Messages</span></a>
                            </li> */ ?>
                        </ul>
                    </li>
                    <?php if (isLoggedIn()) { ?>
                    <li<?php echo $active['friends'] ?>>
                        <a title="Friends" href="#friends-collapse" data-toggle="collapse"><em class="sidebar-item-icon icon-globe"></em><em class="sidebar-item-caret fa pull-right fa-angle-right"></em><div class="label pull-right label-success"></div><span>Friends</span></a>
                        <ul id="friends-collapse" class="nav sidebar-subnav collapse">
                            <li class="sidebar-subnav-header">
                                <a><em class="sidebar-item-icon fa fa-angle-left"></em>Friends</a>
                            </li>
                            <li>
                                <a title="List" href="/friends/list/"><em class="sidebar-item-icon"></em><span>List</span></a>
                            </li>
                            <?php /*<li>
                                <a title="Suggestions" href="/friends/suggestions"><em class="sidebar-item-icon"></em><span>Suggestions</span></a>
                            </li>*/ ?>
                        </ul>
                    </li>
                    <?php } ?>

                    <li>
                        <hr>
                    </li>
                    <li>
                        <a title="Report a bug" href="//github.com/Tras/TrasReport/issues/new"><em class="sidebar-item-icon icon-bug"></em><span>Report a Bug</span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</aside>