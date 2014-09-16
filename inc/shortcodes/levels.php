<?php
/*
	Based on the pmpro_levels shortcode bundled in the Paid Memberships Pro plugin.
	
	This shortcode will display the membership levels and additional content based on the defined attributes.
*/
function pmprot_levels_shortcode($atts, $content=null, $code="")
{
	// $atts    ::= array of attributes
	// $content ::= text within enclosing form of shortcode element
	// $code    ::= the shortcode found, when == callback name
	// examples: [pmprot_levels levels="1,2,3" layout="table" hightlight="2" description="false" checkout_button="Register Now"]

	extract(shortcode_atts(array(
		'levels' => NULL,		
		'layout' => 'div',
		'highlight' => NULL,
		'description' => '1',
		'price' => 'short',
		'expiration' => '1',
		'checkout_button' => 'Select',
		'more_button' => NULL
	), $atts));
	
	//turn 0's into falses
	if($description === "0" || $description === "false" || $description === "no")
		$description = false;
	else
		$description = true;
		
	if($expiration === "0" || $expiration === "false" || $expiration === "no")
		$expiration = false;
	else
		$expiration = true;
	
	if($more_button === "0" || $more_button === "false" || $more_button === "no" || empty($more_button))
		$more_button = false;
	elseif($more_button === "1" || $more_button === "true" || $more_button === "yes")
		$more_button = "Read More";
		
	if($price === "0" || $price === "false" || $price === "hide")
		$show_price = false;
	else
		$show_price = true;

	global $current_user, $membership_levels;

	ob_start();	
		
		global $wpdb, $pmpro_msg, $pmpro_msgt, $current_user, $pmpro_currency_symbol, $pmpro_all_levels, $pmpro_visible_levels;
		
		//make sure pmpro_levels has all levels
		if(!isset($pmpro_all_levels))
			$pmpro_all_levels = pmpro_getAllLevels(true, true);
		if(!isset($pmpro_visible_levels))
			$pmpro_visible_levels = pmpro_getAllLevels(false, true);
		
		if($pmpro_msg)
		{
			?>
			<div class="pmpro_message <?php echo $pmpro_msgt?>"><?php echo $pmpro_msg?></div>
			<?php
		}
		
		$pmpro_levels_filtered = array();
		if(!empty($levels))
		{
			$levels_order = explode(",", $levels);
			//loop through $levels_order array and pull levels from $levels
			foreach($levels_order as $level_id)
			{
				foreach($pmpro_all_levels as $level)
				{
					if($level->id == $level_id)
					{
						$pmpro_levels_filtered[] = $level;
						break;
					}
				}
			}
		}
		else
			$pmpro_levels_filtered = $pmpro_visible_levels;
			
		if($layout == 'table')
		{
			?>
			<table id="pmpro_levels" class="pmpro_levels-table">
			<thead>
			  <tr>
				<th><?php _e('Level', 'pmpro');?></th>
				<?php if(!empty($show_price)) { ?>
					<th><?php _e('Price', 'pmpro');?></th>	
				<?php } ?>
				<?php if(!empty($expiration)) { ?>
					<th><?php _e('Expiration', 'pmpro');?></th>
				<?php } ?>
				<th>&nbsp;</th>
			  </tr>
			</thead>
			<tbody>
			<?php	
				$count = 0;
				foreach($pmpro_levels_filtered as $level)
				{
				  if(isset($current_user->membership_level->ID))
					  $current_level = ($current_user->membership_level->ID == $level->id);
				  else
					  $current_level = false;
				?>
				<tr class="<?php if($current_level == $level) { echo 'pmpro_level-current'; } if($highlight == $level->id) { echo 'pmpro_level-highlight'; } ?>">
					<td>
						<h2><?php echo $level->name?></h2>
						<?php if(!empty($description)) { echo wpautop($level->description); } ?>
						<?php 
							$level_page = pmprot_getLevelLandingPage($level->id);
							if(!empty($level_page))
							{
								?>
								<p><a href="<?php echo get_permalink($level_page->ID); ?>"><?php echo $more_button; ?></a></p>
								<?php
							}
						?>
					</td>
					<?php if(!empty($show_price)) { ?>
					<td>
						<?php 
							if($price === 'full')
								echo pmprot_getLevelCost($level, true, false); 
							else
								echo pmprot_getLevelCost($level, true, true); 
						?>
					</td>
					<?php } ?>
					<?php 
						if(!empty($expiration)) 
						{ 
							?>
							<td>
							<?php 
								$level_expiration = pmpro_getLevelExpiration($level);
								if(empty($level_expiration))
									_e('Membership Never Expires.', 'pmpro');
								else
									echo $level_expiration;
							?>
							</td>
							<?php 
						} 
					?>
					<td>
					<?php if(empty($current_user->membership_level->ID)) { ?>
						<a class="pmpro_btn pmpro_btn-select" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php echo $checkout_button; ?></a>
					<?php } elseif ( !$current_level ) { ?>                	
						<a class="pmpro_btn pmpro_btn-select" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php echo $checkout_button; ?></a>
					<?php } elseif($current_level) { ?>      
						
						<?php
							//if it's a one-time-payment level, offer a link to renew				
							if(!pmpro_isLevelRecurring($current_user->membership_level) && !empty($current_user->membership_level->enddate))
							{
							?>
								<a class="pmpro_btn pmpro_btn-select" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php _e('Renew', 'pmpro');?></a>
							<?php
							}
							else
							{
							?>
								<a class="pmpro_btn disabled" href="<?php echo pmpro_url("account")?>"><?php _e('Your&nbsp;Level', 'pmpro');?></a>
							<?php
							}
						?>
						
					<?php } ?>
					</td>
				</tr>
				<?php
				}
			?>
			</tbody>
			</table>
			<?php
		}
		//'div' or No layout specified - use 'div'
		else
		{
			?>
			<div id="pmpro_levels" class="pmpro_levels-<?php echo $layout; ?>">
			<?php if(count($pmpro_levels) > 1) { ?>
				<div class="container12"><div class="row">
			<?php } ?>
			<?php	
				$count = 0;
				foreach($pmpro_levels_filtered as $level)
				{
					$count++;				
					if(isset($current_user->membership_level->ID))
					  $current_level = ($current_user->membership_level->ID == $level->id);
					else
					  $current_level = false;
				?>
				<div class="column<?php
					if($layout == '2col') { echo '6'; if($count == 2) { echo ' omega'; } }
					elseif($layout == '3col') { echo '4'; if($count == 3) { echo ' omega'; } }
					elseif($layout == '4col') { echo '3'; if($count == 4) { echo ' omega'; } } 
					else { if(count($pmpro_levels) > 1) { echo '12'; } } 
					if($count == 1 || ($layout == 'div' || empty($layout))) { echo ' alpha'; }
				?>">
				<div class="hentry post <?php if($current_level == $level) { echo 'pmpro_level-current'; } if($highlight == $level->id) { echo 'pmpro_level-highlight'; } ?>">
					<h2><?php echo $level->name?></h2>
					<?php if((!empty($description) || !empty($more_button)) && ($layout == 'div' || $layout == '2col' || empty($layout))) { ?>
						<div class="entry-content">
							<?php echo wpautop($level->description); ?>
							<?php 
								$level_page = pmprot_getLevelLandingPage($level->id);
								if(!empty($level_page))
								{
									?>
									<p><a href="<?php echo get_permalink($level_page->ID); ?>"><?php echo $more_button; ?></a></p>
									<?php
								}
							?>
						</div>
					<?php } ?>
					<?php if($layout == 'div' || $layout == '2col' || empty($layout)) { ?>
						<footer class="entry-footer">	
						<?php 
							if(empty($current_user->membership_level->ID)) 
							{ 
								?>
								<a class="pmpro_btn pmpro_btn-select <?php if($layout == 'div' || $layout == '2col' || empty($layout)) { echo 'alignright'; } ?>" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php echo $checkout_button; ?></a>
								<?php 
							}
							elseif(!$current_level) 
							{ 
								?>                	
								<a class="pmpro_btn pmpro_btn-select <?php if($layout == 'div' || $layout == '2col' || empty($layout)) { echo 'alignright'; } ?>" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php echo $checkout_button; ?></a>
								<?php
							}
							elseif($current_level)
							{
								//if it's a one-time-payment level, offer a link to renew				
								if(!pmpro_isLevelRecurring($current_user->membership_level) && !empty($current_user->membership_level->enddate))
								{
									?>
									<a class="pmpro_btn pmpro_btn-select <?php if($layout == 'div' || $layout == '2col' || empty($layout)) { echo 'alignright'; } ?>" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php _e('Renew', 'pmpro');?></a>
									<?php
								}
								else
								{
									?>
									<a class="pmpro_btn disabled <?php if($layout == 'div' || $layout == '2col' || empty($layout)) { echo 'alignright'; } ?>" href="<?php echo pmpro_url("account")?>"><?php _e('Your&nbsp;Level', 'pmpro');?></a>
									<?php
								}
							} 
						?>
						
						<?php
							if(!empty($show_price))
							{
								?>
								<p class="pmpro_level-price">
								<?php
									if(pmpro_isLevelFree($level))
									{
										if(!empty($expiration))
										{
											?>
											<strong><?php _e('Free.', 'pmpro'); ?></strong>
											<?php
										}
										else
										{	
											?>
											<strong><?php _e('Free', 'pmpro'); ?></strong>
											<?php
										}
									}
									elseif($price === 'full')
										echo pmprot_getLevelCost($level, true, false); 
									else
										echo pmprot_getLevelCost($level, true, true); 
								?>
								</p>
								<?php
							}
						?>
		
						<?php 
							if(!empty($expiration)) 
							{ 
								$level_expiration = pmpro_getLevelExpiration($level);
								if(empty($level_expiration))
									_e('Membership Never Expires.', 'pmpro');
								else
									echo $level_expiration;
							} 
						?>
						<?php if($layout == 'div' || $layout == '2col' || empty($layout)) { echo '<div class="clear"></div>'; } ?>
						</footer> <!-- .entry-footer -->
						<?php 
						} 
						else
						{
							//This is a column-type div layout
							?>
							<div class="entry-content">
								<?php
									if(!empty($show_price))
									{
										?>
										<p class="pmpro_level-price">
										<?php
											if($price === 'full')
												echo pmprot_getLevelCost($level, true, false); 
											else
												echo pmprot_getLevelCost($level, true, true); 
										?>
										</p>
										<?php
									}
								?>
								
								<p class="pmpro_level-select"><?php 
									if(empty($current_user->membership_level->ID)) 
									{ 
										?>
										<a class="pmpro_btn pmpro_btn-select" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php echo $checkout_button; ?></a>
										<?php 
									}
									elseif(!$current_level) 
									{ 
										?>                	
										<a class="pmpro_btn pmpro_btn-select" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php echo $checkout_button; ?></a>
										<?php
									}
									elseif($current_level)
									{
										//if it's a one-time-payment level, offer a link to renew				
										if(!pmpro_isLevelRecurring($current_user->membership_level) && !empty($current_user->membership_level->enddate))
										{
											?>
											<a class="pmpro_btn pmpro_btn-select" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php _e('Renew', 'pmpro');?></a>
											<?php
										}
										else
										{
											?>
											<a class="pmpro_btn disabled" href="<?php echo pmpro_url("account")?>"><?php _e('Your&nbsp;Level', 'pmpro');?></a>
											<?php
										}
									} 
								?></p>

								<?php 
									if(!empty($description))
										echo wpautop($level->description); 
								?>
								
								<?php 
									$level_page = pmprot_getLevelLandingPage($level->id);
									if(!empty($level_page))
									{
										?>
										<p><a href="<?php echo get_permalink($level_page->ID); ?>"><?php echo $more_button; ?></a></p>
										<?php
									}
								?>
						</div> <!-- .entry-content -->		
						<?php
							if(!empty($expiration)) 
							{ 
								echo '<footer class="entry-footer pmpro_level-expiration">';
								$level_expiration = pmpro_getLevelExpiration($level);
								if(empty($level_expiration))
									_e('Membership Never Expires.', 'pmpro');
								else
									echo $level_expiration;
								echo '</footer>';
							} 
						?>

							<?php
						}
					?>
				</div></div>
				<?php
				}
			?>
			<?php if(count($pmpro_levels) > 1) { ?>
				</div></div> <!-- row -->
			<?php } ?>
			</div> <!-- #pmpro_levels -->
		<?php
		} //end else if no layout specified, use 'div'
	?>
		
		
		<nav id="nav-below" class="navigation" role="navigation">
			<div class="nav-previous alignleft">
				<?php if(!empty($current_user->membership_level->ID)) { ?>
					<a href="<?php echo pmpro_url("account")?>"><?php _e('&larr; Return to Your Account', 'pmpro');?></a>
				<?php } else { ?>
					<a href="<?php echo home_url()?>"><?php _e('&larr; Return to Home', 'pmpro');?></a>
				<?php } ?>
			</div>
		</nav>	
	<?php
	$temp_content = ob_get_contents();
	ob_end_clean();
	return $temp_content;
}
add_shortcode("pmprot_levels", "pmprot_levels_shortcode");