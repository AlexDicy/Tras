<?php

    $replies = Shared::get("get")['posts']->getReplies($info['id'], 20);
    $text = Shared::parsePost($info['content']);

    $hasOpinion = $info['has_opinion'];
    $opinion = $info['has_opinion'] == 1 ? true : false;
    $likeClass = $hasOpinion ? " active" : " active";
    $dislikeClass = $hasOpinion ? " active" : " active";
    $value = is_null($hasOpinion);
    if (!$value && $opinion) {
        $likeClass = " active" ;
        $dislikeClass = "";
    } else if (!$value && !$opinion) {
        $likeClass = "";
        $dislikeClass = " active";
    }

    $userid = isLoggedIn() ?  Shared::$USERDATA['info']['id'] : 0;
?>
    <div class="post post-margin-bottom">
        <div class="portlet<?= isLoggedIn() ? "" : " full-margin-bottom" ?>">
            <div class="portlet-title">
            <?php
            if ($info["post"] != 0) {
                ?>
                <div><a href="/post/<?= $info['post_nick']."/".$info['post'] ?>/">See the main post</a></div>
                <?php
            }
            ?>
                <div class="caption">
                    <a href="/user/<?php echo $info['nick'] ?>/"><span class="caption-subject"><?php echo $info['nick'] ?><?= Shared::getVerifiedBadge($info["verified"]) ?></span></a>
                    <a href="/post/<?php echo $info['nick']."/".$info['id'] ?>/"><span class="caption-helper"><small> <?php echo date("H:i d/m/Y", strtotime($info['date'])) ?></small></span></a>
                </div>
                <?php if (isLoggedIn()) { ?>
                <div class="actions post-menu">
                    <a href="#menu" class="post-menu-toggler<?php if ($info['user'] ==  Shared::$USERDATA['info']['id']) {echo " owner";} ?>" data-post-id="<?php echo $info['id'] ?>" data-post-user="<?php echo $info['nick'] ?>"><span class="caret"></span></a>
                </div>
                <?php } ?>
            </div>
            <div class="portlet-body">
                <p><?php echo nl2br($text) ?></p>
            </div>
            <div class="post-footer">
                <div class="actions">
                    <!-- Opinion counts -->
                    <a class="opinions-counter" data-post-id="<?php echo $info['id'] ?>">
                        <i class="fa fa-heart"></i> <?php echo empty($info['likes']) ? "0" : $info['likes'] ?> &mdash; 
                        <i class="fa fa-thumbs-down"></i> <?php echo empty($info['dislikes']) ? "0" : $info['dislikes'] ?>
                    </a>

                    <!-- Opinion buttons -->
                    <?php if (isLoggedIn()) { ?>
                        <?php if($info['user'] != $userid): ?>
                            <a href="javascript:;" data-post-id="<?php echo $info['id'] ?>" class="like-btn pbtn pbtn-blue<?php echo $likeClass ?>">
                                <i class="fa fa-heart"></i>
                                Like
                            </a>
                            <a href="javascript:;" data-post-id="<?php echo $info['id'] ?>" class="dislike-btn pbtn pbtn-red<?php echo $dislikeClass ?>">
                                <i class="fa fa-thumbs-down"></i>
                                Dislike
                            </a>
                        <?php endif; ?>
                    <!-- Share -->
                    <a href="javascript:;" data-post-id="<?php echo $info['id'] ?>" data-post-user="<?php echo $info['nick'] ?>" class="share-btn pbtn pbtn-white active">
                        <i class="fa fa-share"></i>
                        Share
                    </a>
                    <?php } /*<a href="javascript:;" data-post-id="<?php echo $info['id'] ?>" data-post-user="<?php echo $info['nick'] ?>" class="share-btn pbtn pbtn-white active">
                        <i class="fa fa-comment"></i>
                        Reply
                    </a>
                    <?php } /*<a href="javascript:;" class="share-btn pbtn pbtn-white active">
                        <i class="fa fa-comment"></i>
                        Reply
                    </a>*/ ?>
                </div>
                <?php if (isLoggedIn()) { ?><input type="text" data-post-id="<?php echo $info['id'] ?>" data-post-user="<?php echo $info['user'] ?>" placeholder="Reply to <?php echo $info['nick'] ?>'s post" class="form-control send-reply-input" /> <?php } ?>
                <?php
                if ($replies) {
                    echo "<ul class=\"replies\">";
                    while ($reply = mysqli_fetch_array($replies)) {
                        include "template/reply.php";
                    }
                    echo "</ul>";
                }
                ?>
            </div>
        </div>
    </div>
