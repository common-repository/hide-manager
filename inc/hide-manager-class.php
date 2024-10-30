<?php
/*
	File Name: hide-manager-class.php
*/

class HideManager {
	
	public function __construct(){

		/* Add Menu to admin*/
		add_action('admin_menu', array( $this,'HM_add_menu'));

		/* hide title from post and page */
		add_filter( 'the_title', array( $this,'HM_hide_post_page_title'), 10, 2 );

		/* hide featured image from post if option selected */
		add_filter( 'post_thumbnail_html', array( $this,'HM_hide_featured_image'), 10, 2 );

		/* Hide Comment from posts and pages if option selected*/
		add_filter('comments_open', array( $this,'HM_close_post_page_comment'), 10, 2);
	}
	
	/*
		function for plugin activation hook
	*/
	public function HM_plugin_activation() {
		/* no activation setup */
  	}

  	/*
		function for plugin deactivation hook
  	*/
  	public function HM_plugin_deactivation() {
  		/* no activation setup */
  	}
	/*
		plugin function register menu.
  	*/
	public function HM_add_menu() {
		add_submenu_page('options-general.php', 'Hide Manager', 'Hide Manager', 'manage_options', 'hide-manager', array($this,'HM_setting'));
	}
	/*
		plugin function for display Hide Manager plugin setting.
  	*/
	public function HM_setting() { ?>
		<div class="wrap">
            <h1><?php _e('Hide Manager','hide-manager');?></h1>
			<h2><?php _e('The Hide Manager Plugin is now installed and ready to use with your WordPress site.','hide-manager');?></h2>
			<div id="welcome-panel" class="welcome-panel">
				<div class="welcome-panel-content">
					<div class="welcome-panel-column-container">
						<div class="welcome-panel-column">
							<p><img src="http://www.themebuffer.com/wp-content/uploads/2017/10/Themebuffer-Logo.png" class="img-responsive img-centered" alt=""></p>
						</div>
						<div class="welcome-panel-column">
							<p>
								<?php _e('Follow us for more updates','hide-manager');?><a href="https://www.facebook.com/scissorthemes"> <?php _e('Facebook','hide-manager');?></a>
							</p>
							<p>
								<?php _e('Your review on WordPress will be highly appreciated, as it encourages us to keep updating and supporting the product.','hide-manager');?><a href="https://wordpress.org/support/theme/writee/reviews/#new-post"><?php _e('Add your review','hide-manager');?></a>
							</p>
							<p>
								<?php _e('To share your feedback and for any support query you can reach us at','hide-manager');?> <a href="https://www.themebuffer.com/support"> <?php _e('Support');?></a>
							</p>
						</div>
					</div>
				</div>
			</div>
            <h2 class="nav-tab-wrapper">
            	<a href="<?php echo admin_url( 'options-general.php?page=hide-manager' ); ?>" class="nav-tab<?php if ( ! isset( $_GET['action'])) echo ' nav-tab-active'; ?>"><?php _e( 'Hide Page Title', 'hide-manager'); ?></a>
				<a href="<?php echo esc_url( add_query_arg( array( 'action' => 'hide-post-title' ), admin_url( 'options-general.php?page=hide-manager' ) ) ); ?>" class="nav-tab<?php if ( isset( $_GET['action']) && $_GET['action'] == 'hide-post-title') echo ' nav-tab-active'; ?>"><?php _e( 'Hide Post Title', 'hide-manager'); ?></a> 
				<a href="<?php echo esc_url( add_query_arg( array( 'action' => 'hide-featured-image' ), admin_url( 'options-general.php?page=hide-manager' ) ) ); ?>" class="nav-tab<?php if ( isset($_GET['action']) && $_GET['action'] == 'hide-featured-image' ) echo ' nav-tab-active'; ?>"><?php _e( 'Hide Featured Image', 'hide-manager'); ?></a>
				<a href="<?php echo esc_url( add_query_arg( array( 'action' => 'hide-post-comment' ), admin_url( 'options-general.php?page=hide-manager' ) ) ); ?>" class="nav-tab<?php if ( isset( $_GET['action']) && $_GET['action'] == 'hide-post-comment') echo ' nav-tab-active'; ?>"><?php _e( 'Hide Comment from Post', 'hide-manager'); ?></a> 
				<a href="<?php echo esc_url( add_query_arg( array( 'action' => 'hide-page-comment' ), admin_url( 'options-general.php?page=hide-manager' ) ) ); ?>" class="nav-tab<?php if ( isset( $_GET['action']) && $_GET['action'] == 'hide-page-comment') echo ' nav-tab-active'; ?>"><?php _e( 'Hide Comment from Pages', 'hide-manager'); ?></a>         
			</h2>
			<form method="post">
				<?php 
				if(isset($_GET['action']) && $_GET['action'] == 'hide-post-title') { ?>
					<?php 
						if(isset($_POST['submit'])){
						/* Hide Post Title */
							if($_POST['hidetitle'] == 1){
								update_option( 'hide_title_post', 1);
								update_option( 'hide_title_post_text', '');
							}elseif($_POST['hidetitle'] == 2){
								if(empty($_POST['hide_title_post_text'])){
									$errMsgPost = "Please enter Post title.";
									update_option( 'hide_title_post', '');
									update_option( 'hide_title_post_text', '');
								}else{
									update_option( 'hide_title_post', 2);
									update_option( 'hide_title_post_text', $_POST['hide_title_post_text']);
								}
							}else{
								update_option( 'hide_title_post', '');
								update_option( 'hide_title_post_text', '');
							}
						}
						/* Fetch Post title value*/
						$this->post_title = get_option('hide_title_post');
						$this->hide_title_post_text = get_option('hide_title_post_text');
					?>
					<div id="postTitle" class="tab-pane fade">
			            <h3><?php _e('Hide Post Title (Detail Post)','hide-manager' );?></h3>
			            <!-- Hide title from Post -->
						<script type="text/javascript">
						    jQuery(function () {
						        jQuery("#hideposttitle").change(function () {
						            if (jQuery(this).val() == "2") {
						                jQuery("#enterpostID").show();
						            } else {
						                jQuery("#enterpostID").hide();
						            }
						        });
						    });
						</script>
						<select name="hidetitle" id="hideposttitle" style="width:40%">
							<option value="0" <?php if($this->post_title == 0){ echo 'selected';}?>><?php _e('--Select--','hide-manager');?></option>
							<option value="1" <?php if($this->post_title == 1){ echo 'selected';}?>><?php _e('All Posts','hide-manager');?></option>
							<option value="2" <?php if($this->post_title == 2){ echo 'selected';}?>><?php _e('Enter Post ID(s)','hide-manager');?></option>
						</select>
						<br>
						<div id="enterpostID" <?php if($this->hide_title_post_text !=''){ echo 'style="display:block" ';} else{ echo 'style="display:none;"';}?>>
						    <input type="text" style="width:40%" name="hide_title_post_text" value="<?php echo $this->hide_title_post_text;?>" placeholder="Enter Post Id for e.g 1,2">
						</div>
						<p><?php _e('By selecting <b>All</b>, it will <b>Hide All Post Titles</b>.', 'hide-manager');?></p>
						<p><?php _e('By selecting <b>Enter Post IDs</b>, to <b>Hide Posts Title</b> from <b>Selected Posts.', 'hide-manager');?></p>
						<!-- End Hide title from Post -->
			        </div>
				<?php	submit_button();
				} elseif(isset($_GET['action']) && $_GET['action'] == 'hide-featured-image') { ?>
					<?php 
						if(isset($_POST['submit'])){
							/* Hide featured Image*/
							if($_POST['hide_featured_image'] == 1){
								update_option( 'hide_featured_image', 1);
								update_option( 'hide_title_featured_image_text', '');
							}elseif($_POST['hide_featured_image'] == 2){
								if(empty($_POST['hide_title_featured_image_text'])){
									$errMsgPost = "Please enter Post title.";
									update_option( 'hide_featured_image', '');
									update_option( 'hide_title_featured_image_text', '');
								}else{
									update_option( 'hide_featured_image', 2);
									update_option( 'hide_title_featured_image_text', $_POST['hide_title_featured_image_text']);
								}
							}else{
								update_option( 'hide_featured_image', '');
								update_option( 'hide_title_featured_image_text', '');
							}
						}
					/* Fetch Fetured Image value*/
					$this->featured_image = get_option( 'hide_featured_image');
					$this->hide_title_featured_image_text = get_option( 'hide_title_featured_image_text');
					?>
					<div id="featuredImage" class="tab-pane fade">
						<h3><?php _e('Hide Featured Image (Detail Post)','hide-manager');?></h3>
						<!-- Hide Featured Image from Post -->
						<script type="text/javascript">
						    jQuery(function () {
						        jQuery("#hidefeaturedimage").change(function () {
						            if (jQuery(this).val() == "2") {
						                jQuery("#enterfeaturedpostID").show();
						            } else {
						                jQuery("#enterfeaturedpostID").hide();
						            }
						        });
						    });
						</script>
						<select name="hide_featured_image" id="hidefeaturedimage" style="width:40%">
							<option value="0" <?php if($this->featured_image == 0){ echo 'selected';}?>><?php _e('--Select--','hide-manager');?></option>
							<option value="1" <?php if($this->featured_image == 1){ echo 'selected';}?>><?php _e('All Posts','hide-manager');?></option>
							<option value="2" <?php if($this->featured_image == 2){ echo 'selected';}?>><?php _e('Enter Post ID(s)','hide-manager');?></option>
						</select>
						<br>
						<div id="enterfeaturedpostID" <?php if($this->hide_title_featured_image_text !=''){ echo 'style="display:block" ';} else{ echo 'style="display:none;"';}?>>
						    <input type="text" style="width:40%" name="hide_title_featured_image_text" value="<?php echo $this->hide_title_featured_image_text;?>" placeholder="enter Post Id for e.g 1,2">
						</div>
						<p><?php _e('By selecting <b>All</b>, it will <b>Hide All Featured Images from Posts</b>.', 'hide-manager');?></p>
						<p><?php _e('By selecting <b>Enter Featured Image Post IDs</b>, to <b>Hide Featured Image</b> from <b>Selected Posts</b>.', 'hide-manager');?>.</p>
						<p><strong><?php _e('Note: If you have included the featured image function from another, it would not work. The featured image function must be written inside the single.php. Since most of the premium themes include the featured image function (the_post_thumbnail ()) from another another file so it might not work on the premium themes.', 'hide-manager');?></strong></p>
						<!-- End Hide Featured Image from Post -->
			        </div>
				<?php	submit_button();
				}elseif(isset($_GET['action']) && $_GET['action'] == 'hide-post-comment'){ ?>
					<?php
					if(isset($_POST['submit'])){
					/* Hide Comment from posts */
						if($_POST['hide_post_comment'] == 1){
							update_option( 'hide_post_comment', 1);
							update_option( 'hide_comment_post_text', '');
						}elseif($_POST['hide_post_comment'] == 2){
							if(empty($_POST['hide_comment_post_text'])){
								$errMsgpost = 'Please enter Post ID.';
								update_option( 'hide_post_comment', '');
								update_option( 'hide_comment_post_text', '');
							}else{
								update_option( 'hide_post_comment', 2);
								update_option( 'hide_comment_post_text', $_POST['hide_comment_post_text']);
							}
						}else{
							update_option( 'hide_post_comment', '');
							update_option( 'hide_comment_post_text', '');
						}
					}
					/* fetch Comments values from posts*/
					$this->post_comment = get_option( 'hide_post_comment');
					$this->hide_comment_post_text = get_option('hide_comment_post_text');
					?>
					<div id="postComment" class="tab-pane fade">
			            <h3><?php _e('Hide Comment from Post','hide-manager');?></h3>
			            <!-- Hide Comment from Post & Page -->
						<script type="text/javascript">
						    jQuery(function () {
						        jQuery("#hidePostComment").change(function () {
						            if (jQuery(this).val() == "2") {
						                jQuery("#entercommentpostID").show();
						            } else {
						                jQuery("#entercommentpostID").hide();
						            }
						        });
						    });
						</script>
						<select name="hide_post_comment" id="hidePostComment" style="width:40%">
							<option value="0" <?php if($this->post_comment == 0){ echo 'selected';}?>><?php _e('--Select--','hide-manager');?></option>
							<option value="1" <?php if($this->post_comment == 1){ echo 'selected';}?>><?php _e('All Posts','hide-manager');?></option>
							<option value="2" <?php if($this->post_comment == 2){ echo 'selected';}?>><?php _e('Enter Post ID(s)','hide-manager');?></option>
						</select>
						<br>
						<div id="entercommentpostID" <?php if($this->hide_comment_post_text !=''){ echo 'style="display:block" ';} else{ echo 'style="display:none;"';}?>>
						    <input type="text" style="width:40%" name="hide_comment_post_text" value="<?php echo $this->hide_comment_post_text;?>" placeholder="Enter Post Id for e.g 1,2">
						</div>
						<p><?php _e('By selecting <b>All</b>, it will<b> Hide Comments from All Posts</b>.', 'hide-manager');?></p>
						<p><?php _e('By selecting <b>Enter Post ID</b>, to <b>Hide Comments</b> from <b>Selected Posts</b>.', 'hide-manager');?></p>
						<!-- End Hide Comment from Post & Page -->
			        </div>
				<?php	submit_button(); 
				}elseif(isset($_GET['action']) && $_GET['action'] == 'hide-page-comment'){ ?>
					<?php
					if(isset($_POST['submit'])){
					/* Hide Comment from Pages */
						if($_POST['hide_page_comment'] == 1){
							update_option( 'hide_page_comment', 1);
							update_option( 'hide_page_comment_text', '');
						}elseif($_POST['hide_page_comment'] == 2){
							if(empty($_POST['hide_page_comment_text'])){
								 $errMsg = 'Please enter Page ID.';
								 update_option( 'hide_page_comment', '');
								 update_option( 'hide_page_comment_text', '');
							}else{
								update_option( 'hide_page_comment', 2);
								update_option( 'hide_page_comment_text', $_POST['hide_page_comment_text']);
							}
						}else{
							update_option( 'hide_page_comment', '');
							update_option( 'hide_page_comment_text', '');
						}
					}
					/* fetch Comments values from Pages*/
					$this->page_comment = get_option( 'hide_page_comment');
					$this->hide_page_comment_text = get_option('hide_page_comment_text');
					?>
					<div id="pageComment" class="tab-pane fade">
			            <h3><?php _e('Hide Comment from Pages','hide-manager');?></h3>
			            <!-- Hide Comment from Pages -->
						<script type="text/javascript">
						    jQuery(function () {
						        jQuery("#hidePageComment").change(function () {
						            if (jQuery(this).val() == "2") {
						                jQuery("#entercommentpageID").show();
						            } else {
						                jQuery("#entercommentpageID").hide();
						            }
						        });
						    });
						</script>
						<select name="hide_page_comment" id="hidePageComment" style="width:40%">
							<option value="0" <?php if($this->page_comment == 0){ echo 'selected';}?>><?php _e('--Select--','hide-manager');?></option>
							<option value="1" <?php if($this->page_comment == 1){ echo 'selected';}?>><?php _e('All Pages','hide-manager');?></option>
							<option value="2" <?php if($this->page_comment == 2){ echo 'selected';}?>><?php _e('Enter Page ID(s)','hide-manager');?></option>
						</select>
						<br>
						<div id="entercommentpageID" <?php if($this->hide_page_comment_text !=''){ echo 'style="display:block" ';} else{ echo 'style="display:none;"';}?>>
						    <span class = "error"><?php if(isset($errMsg)) {echo $errMsg;}?></span>
						    <input type="text" style="width:40%" name="hide_page_comment_text" id="pageID" value="<?php echo $this->hide_page_comment_text;?>" placeholder="Enter Page Id for e.g 1,2">
						</div>
						<p><?php _e('By selecting <b>All</b>, it will <b>Hide Comments from All Pages</b>.', 'hide-manager');?></p>
						<p><?php _e('By selecting <b>Enter Page IDs</b>, to<b> Hide Comments</b> from<b> Selected Pages</b>.', 'hide-manager');?></p>
						<!-- End Hide Comment from Pages -->
			        </div>
				<?php	submit_button(); 
				} else{ ?>
				<?php
					if(isset($_POST['submit'])){
						/*Hide Page title*/
						if($_POST['hide_page_title'] == 1){
							update_option( 'hide_page_title', 1 );
							update_option( 'hide_page_title_text', '' );
						}elseif($_POST['hide_page_title'] == 2){
							if(empty($_POST['hide_page_title_text'])){
								$errMsgPage = "Please enter Page title!";
								update_option( 'hide_page_title', '' );
								update_option( 'hide_page_title_text', '' );
							}else{
								update_option( 'hide_page_title', 2 );
								update_option( 'hide_page_title_text', $_POST['hide_page_title_text']);
							}
						}else{
							update_option( 'hide_page_title', '' );
							update_option( 'hide_page_title_text', '' );
						}
					}

					/* Fetch Page title value*/
					$this->page_title = get_option( 'hide_page_title');
					$this->hide_page_title_text = get_option( 'hide_page_title_text');
					?>
					<div id="pageTitle" class="tab-pane fade in active">
			            <h3><?php _e('Hide Page Title (Detail Page)','hide-manager');?></h3>
			            <!-- Hide title from Page -->
						<script type="text/javascript">
						    jQuery(function () {
						        jQuery("#hidepagetitle").change(function () {
						            if (jQuery(this).val() == "2") {
						                jQuery("#enterpageID").show();
						            } else {
						                jQuery("#enterpageID").hide();
						            }
						        });
						    });
						</script>										
						<select name="hide_page_title" id="hidepagetitle" style="width:40%">
							<option value="0" <?php if($this->page_title == 0){ echo 'selected';}?>><?php _e('--Select--','hide-manager');?></option>
							<option value="1" <?php if($this->page_title == 1){ echo 'selected';}?>><?php _e('All Pages','hide-manager');?></option>
							<option value="2" <?php if($this->hide_page_title_text){ echo 'selected';}?>><?php _e('Enter Page ID(s)','hide-manager');?></option>
						</select>
						<br>
						<div id="enterpageID" <?php if($this->hide_page_title_text !=''){ echo 'style="display:block" ';} else{ echo 'style="display:none;"';}?> class="form-group">
						    <input type="text" style="width:40%" name="hide_page_title_text" value="<?php echo $this->hide_page_title_text;?>" placeholder="enter page Id for e.g 1,2">
						</div>										
						<p><?php _e('By selecting <b>All</b>, it will <b>Hide All Pages Title</b>.', 'hide-manager');?></p>
						<p><?php _e('By selecting <b>Enter Page IDs</b>, to <b>Hide Pages Title</b> from <b>Selected Pages</b>.', 'hide-manager');?></p>
						<!-- End Hide title from Page -->
			        </div>
					<?php submit_button(); 
				}?>
			</form>
        </div>

	<?php }
  	/*
		plugin main function for hide comment from post and pages.
  	*/
	public function HM_close_post_page_comment( $open,$id ) {
		global $post;

    	if( get_post_type( get_the_ID() ) == 'post' && is_singular('post') ){

	    	$this->post_comment = get_option( 'hide_post_comment');
			$this->hide_comment_post_text = get_option('hide_comment_post_text');
			$this->hide_comment_post_text;
			$post_comment_ids = explode(',',$this->hide_comment_post_text);

	    	if ( $this->post_comment == 1 ) { 
		        return false;
		    }elseif( in_array($post->ID, $post_comment_ids) && $post->ID == $id) {
		    	return '';
		    }else{
				return $open;	
			}
    	}elseif(get_post_type( get_the_ID() ) == 'page' && is_singular('page')){

			$this->page_comment = get_option( 'hide_page_comment');
			$this->hide_page_comment_text = get_option('hide_page_comment_text');
			$this->hide_page_comment_text;
			$page_comment_ids = explode(',',$this->hide_page_comment_text);

	    	if ( $this->page_comment  == 1 ) { 
		        return false;
		    }elseif( in_array($post->ID, $page_comment_ids) && $post->ID == $id) {
		    	return  '';
			}else{
				return $open;	
			}
    	}else{
    		return $open;
    	}
	}
  	/*
		plugin main function for hide featured image from post.
  	*/
	public function HM_hide_featured_image( $html, $id ) {
		global $post;
		
		// Condition to hide featured image From Post
	    if( is_single($id) && is_singular('post')){
	    	// Condition to hide page title From Page
			$this->featured_image = get_option( 'hide_featured_image');
			$this->hide_title_featured_image_text = get_option( 'hide_title_featured_image_text');
			$this->hide_title_featured_image_text;
			$post_image_ids = explode(',',$this->hide_title_featured_image_text);

	    	if( $this->featured_image == 1 && in_the_loop()){
	    		return '';
	    	}elseif( in_array($post->ID, $post_image_ids) && $post->ID == $id && in_the_loop()){
	    		return '';
	    	}else{
	    		return $html;
	    	}
	    }else{
	    	return $html;
	    }
	}
	
  	/*
		plugin main function for hide title from post and page.
  	*/
	public function HM_hide_post_page_title( $title, $id ) {

		global $post;
	
		if(is_page($id) && is_singular('page')) {
			$this->page_title = get_option( 'hide_page_title');
			$this->hide_page_title_text = get_option( 'hide_page_title_text');
			$this->hide_page_title_text;
			$post_ids = explode(',',$this->hide_page_title_text);
		    if ( $this->page_title == 1 && $post->ID == $id && in_the_loop()) { 
		        return '';
		    }elseif( in_array($post->ID, $post_ids) && $post->ID == $id && in_the_loop()) {
		    	return '';
		    }else{
		    	return $title;
			}
		}
		/* if page is selected to hide the title*/
	    elseif( is_single($id) && is_singular('post')){
	    	// Condition to hide page title From Page
			$this->post_title = get_option( 'hide_title_post');
			$this->hide_title_post_text = get_option( 'hide_title_post_text');
			$this->hide_title_post_text;
			$post_title_ids = explode(',',$this->hide_title_post_text);
	    	if( $this->post_title == 1 && in_the_loop()){
	    		return '';
	    	}elseif( in_array($post->ID,$post_title_ids) && in_the_loop()){
	    		return '';
	    	 }else{
	    		return $title;
	    	}
	    } 
	    else{
	    	return $title;
	    }
	}	
}
?>