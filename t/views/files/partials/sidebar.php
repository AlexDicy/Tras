<!-- START Sidebar-->
<div data-ng-controller="SidebarController" class="sidebar-wrapper">
   <side-bar>
      <div class="sidebar-nav">
         <!-- START sidebar buttons-->
         <div class="sidebar-buttons">
            <div compile="t/views/view.php?name=partials/summary.php" class="btn-sidebar">
               <div class="mb center-block img-circle img-responsive thumb64" style="background-image: url('<?php echo $avatar ?>');background-size: cover;background-position: center;background-repeat: no-repeat;"></div>
               <div class="text-center">
                  <h4 class="text-bold m0"><?php echo $nickname ?></h4>
                  <small><?php echo $friends ?></small>
               </div>
            </div>
            <div class="text-center">
               <div class="text-muted mt-sm clearfix">
                  <a href="#" compile="t/views/view.php?name=partials/contacts.html" class="text-sm btn-sidebar pull-left">
                     <em class="icon-speech-bubble fa-fw"></em>
                  </a>
                  <a href="#" compile="t/views/view.php?name=partials/settings.html" class="text-sm btn-sidebar pull-right">
                     <em class="icon-cog fa-fw"></em>
                  </a>
               </div>
            </div>
         </div>
         <!-- END sidebar buttons-->
         <!-- START sidebar nav-->
         <ul class="nav">
            <hr class="hidden-collapsed" />
            <!-- Iterates over all sidebar items-->
            <li data-ng-class="getSidebarItemClass(item)" data-ng-repeat="item in menuItems" data-ng-include="'sidebar-items.html'" data-ng-click="toggleCollapse($index)" data-ng-switch="item.type"></li>
         </ul>
         <!-- END sidebar nav-->
      </div>
   </side-bar>
   <!-- data-ng-template for sidebar item markup-->
   <script type="text/ng-template" id="sidebar-items.html">
      <span data-ng-switch-when="heading" translate="{{item.translate}}" class="text-muted">{{item.text}}</span><hr data-ng-switch-when="separator"/><a data-ng-switch-default="" ui-sref="{{item.sref}}" title="{{item.text}}"><em data-ng-hide="inSubmenu" class="sidebar-item-icon {{item.icon}}"></em><em data-ng-if="item.subnav" data-ng-class="app.layout.isRTL?'fa-angle-left':'fa-angle-right'" class="sidebar-item-caret fa pull-right"></em><div data-ng-if="item.alert" data-ng-class="item.alert.class || 'label-default'" class="label pull-right">{{item.alert.text}}</div><span translate="{{item.translate}}">{{item.text}}</span></a><ul data-ng-switch-default="" data-ng-if="item.subnav" collapse="isCollapse($index)" is-disabled="isSidebarSlider()" data-ng-init="addCollapse($index, item)" data-ng-click="cancel($event)" class="nav sidebar-subnav"><li class="sidebar-subnav-header"><a><em data-ng-class="(app.layout.isRTL)? 'fa-angle-right' : 'fa-angle-left'" class="sidebar-item-icon fa"></em>{{ item.translate | translate }}</a></li><li data-ng-repeat="item in item.subnav" data-ng-include="'sidebar-items.html'" data-ng-class="getSidebarItemClass(item)" data-ng-init="inSubmenu = true" data-ng-switch="item.type"></li></ul>
   </script>
</div>
<!-- END Sidebar-->