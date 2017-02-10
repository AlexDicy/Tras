            <tr>
                <td>
                    <a href="//<?php echo Shared::get("host")."/messages/chat/".$info['chat_id']; ?>" class="media">
                        <div>
                            <img src="<?php echo $info['Avatar']; ?>" class="media-photo pull-left">
                            <div class="media-body">
                                <span class="media-meta pull-right"><?php echo Shared::elapsedTime($info['post_date']); ?></span>
                                <h4 class="chat-title">
                                    <?php echo $info['Nick']; ?>
                                </h4>
                                <?php echo substr(base64_decode($info['content']), 0, 50); echo strlen(base64_decode($info['content']) > 50) ? "...":""; ?>
                            </div>
                        </div>
                    </a>
                </td>
            </tr>