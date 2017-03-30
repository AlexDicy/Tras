<?php
$links = array(
    'twitter' => "https://twitter.com/home?status=%%USERNAME%%%20post%20on%20%23Tras%20https%3A//tras.pw/post/%%USERNAME%%/%%POSTID%%%20via%20%40TrasOfficial",
    'facebook' => "https://www.facebook.com/sharer/sharer.php?u=https%3A//tras.pw/post/%%USERNAME%%/%%POSTID%%",
    'google' => "https://plus.google.com/share?url=https%3A//tras.pw/post/%%USERNAME%%/%%POSTID%%",
    'linkedin' => "https://www.linkedin.com/shareArticle?mini=true&url=https%3A//tras.pw/post/%%USERNAME%%/%%POSTID%%&title=Post%20by%20%%USERNAME%%&summary=Read%20the%20post%20by%20%%USERNAME%%%20on%20Tras&source=https%3A//tras.pw",
    'mail' => "mailto:?&subject=Read the post by %%USERNAME%%&body=Read%20the%20post%20by%20%%USERNAME%%%20on%20Tras%0Ahttps%3A//tras.pw/post/%%USERNAME%%/%%POSTID%%",
    'rawlink' => "https://tras.pw/post/%%USERNAME%%/%%POSTID%%"
);
//class="modal fade in" style="display: block;"
?>
<div id="share-post-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">External share</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">
                    <a id="share-post-modal-button-twitter" title="Twitter" target="_blank" href="<?php echo $links['twitter'] ?>">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-square-o fa-stack-2x"></i>
                            <i class="fa fa-twitter fa-stack-1x"></i>
                        </span>
                    </a>
                    <a id="share-post-modal-button-facebook" title="Facebook" target="_blank" href="<?php echo $links['facebook'] ?>">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-square-o fa-stack-2x"></i>
                            <i class="fa fa-facebook fa-stack-1x"></i>
                        </span>
                    </a>
                    <a id="share-post-modal-button-google" title="Google+" target="_blank" href="<?php echo $links['google'] ?>">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-square-o fa-stack-2x"></i>
                            <i class="fa fa-google-plus fa-stack-1x"></i>
                        </span>
                    </a>
                    <a id="share-post-modal-button-linkedin" title="Linkedin" target="_blank" href="<?php echo $links['linkedin'] ?>">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-square-o fa-stack-2x"></i>
                            <i class="fa fa-linkedin fa-stack-1x"></i>
                        </span>
                    </a>
                    <a id="share-post-modal-button-mail" title="E-mail" target="_blank" href="<?php echo $links['mail'] ?>">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-square-o fa-stack-2x"></i>
                            <i class="fa fa-envelope fa-stack-1x"></i>
                        </span>
                    </a>
                    <form>
                        <label>Direct link</label>
                        <input disabled type="text" id="share-post-modal-input-rawlink" class="form-control" value="<?php echo $links['rawlink'] ?>"/>
                    </form>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>