            <?php
            if ($page == "fulllogin") {
                echo '<div class="center-block col-md-12 mt-xl">';
            } else {
                echo '<div class="center-block mt-xl wd-xl">';
            }
            ?>
                <div class="panel panel-inverse">
                    <?php if (file_exists("pages/$page.php")) {
                        include "pages/$page.php";
                    } else {
                    ?>
                    <p class="text-center">Not found</p>
                    <?php } ?>
                </div>
                <?php include 'template/footer.php' ?>
            </div>