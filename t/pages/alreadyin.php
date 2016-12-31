<div class="center-block mt-xl wd-xl">
    <!-- START panel-->
    <div class="panel panel-inverse">
        <div class="panel-body">
            <p class="text-center pv text-bold">ARLEADY LOGGED IN</p>
            <div class="row">
                <div class="col-lg-12">
                    <p class="lead text-center">What can I do?</p>
                    <button type="submit" data-ng-click="$state.go('app.dashboard')" class="btn btn-block btn-primary mt-lg">Go back</button>
                    <a ui-sref="page.logout" class="btn btn-block btn-default">
                        <strong>Logout</strong>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- END panel-->
    <div data-ng-include="'t/pages/page-footer.html'" class="p-lg text-center"></div>
</div>