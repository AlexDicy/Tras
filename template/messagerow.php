            <tr>
				<td>
					<div class="media">
						<a href="#" class="pull-left">
							<img src="<?php echo $info['Avatar']; ?>" class="media-photo">
						</a>
						<div class="media-body">
							<span class="media-meta pull-right"><?php echo $info['post_date']; ?></span>
							<h4 class="title">
								<?php echo $info['Nick']; ?>
							</h4>
							<p class="summary"><?php echo substr($info['content'], 0, 50); echo strlen($info['content'] > 50) ? "...":""; ?></p>
						</div>
					</div>
				</td>
			</tr>