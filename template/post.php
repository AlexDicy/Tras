<?php

    $replies = Shared::get("get")['posts']->getReplies($info['id'], 20);
    $text = $info['content'];

    // parsing
    if (strpos($text, '!~') !== false){
        // Bold
        $text = str_replace("**", "<b>", $text);
        $text = str_replace("/*", "</b>", $text);

        // Italics
        $text = str_replace("__", "<i>", $text);
        $text = str_replace("/_", "</i>", $text);

        // Superscript
        $text = str_replace("^^", "<sup>", $text);
        $text = str_replace("/^", "</sup>", $text);

        // Subscript
        $text = str_replace("~~", "<sub>", $text);
        $text = str_replace("/~", "</sub>", $text);

        // Quote
        $text = str_replace("&gt;&gt;", "<blockquote>", $text);
        $text = str_replace("/&gt;", "</blockquote>", $text);
        
        $text = str_replace("!~", "", $text);
        $text .= "</i></b></sup></sub>";
    } 

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

    $userid = isLoggedIn() ? $_SESSION['info']['id'] : 0;
?>
    <div class="post post-margin-bottom">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <a href="/user/<?php echo $info['Nick'] ?>/"><span class="caption-subject"><?php echo $info['Nick'] ?><?php if ($info['verified'] == 1) { ?><a> <i class="fa fa-check-circle" style="color: #42A5F5;"></i></a><?php } else if ($info['verified'] == 2) { ?><a> <i class="fa fa-check-circle" style="color: #4CAF50;"></i></a><?php } ?></span></a>
                    <a href="/post/<?php echo $info['Nick']."/".$info['id'] ?>/"><span class="caption-helper"><small> <?php echo date("H:i d/m/Y", strtotime($info['date'])) ?></small></span></a>
                </div>
                <?php if (isLoggedIn()) { ?>
                <div class="actions post-menu">
                    <a href="#menu" class="post-menu-toggler<?php if ($info['user'] == $_SESSION['info']['id']) {echo " owner";} ?>" data-post-id="<?php echo $info['id'] ?>" data-post-user="<?php echo $info['Nick'] ?>"><span class="caret"></span></a>
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
                    <a href="javascript:;" data-post-id="<?php echo $info['id'] ?>" data-post-user="<?php echo $info['Nick'] ?>" class="share-btn pbtn pbtn-white active">
                        <i class="fa fa-share"></i>
                        Share
                    </a>
                    <?php } /*<a href="javascript:;" data-post-id="<?php echo $info['id'] ?>" data-post-user="<?php echo $info['Nick'] ?>" class="share-btn pbtn pbtn-white active">
                        <i class="fa fa-comment"></i>
                        Reply
                    </a>
                    <?php } /*<a href="javascript:;" class="share-btn pbtn pbtn-white active">
                        <i class="fa fa-comment"></i>
                        Reply
                    </a>*/ ?>
                </div>
                <input type="text" data-post-id="<?php echo $info['id'] ?>" data-post-user="<?php echo $info['user'] ?>" placeholder="Reply to <?php echo $info['Nick'] ?>'s post" class="form-control send-reply-input" />
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