<?php
/**
 * completation view to be used to indicate installation is complated
 * 
 * @param $data['pagetitle'] Title and heading of the page
 *
 * @package opix
 * @category View
 * @author Yuqing Wang
 */
?><script type="text/javascript">
    function delayURL(url) {
		var delay = document.getElementById("time").innerHTML;
		if(delay > 0) {
			delay--;
			document.getElementById("time").innerHTML = delay;
		} else {
			window.top.location.href = url;
		}
		setTimeout("delayURL('" + url + "')", 1000);
	}
</script>

<h4><?php echo $this->lang->line('txt_install_success') ?></h4>

<span id="time">3 </span> 

<?php 
echo $this->lang->line("txt_director_description");
echo '<a href="'.base_url().'index.php/login">'.$this->lang->line('link_here').'</a>' ?>

<script type="text/javascript">
delayURL(js_base_url+ "index.php/login");
</script>