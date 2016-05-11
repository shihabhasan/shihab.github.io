jQuery(document).ready(function($) {
 	$('.wp-full-overlay-sidebar-content').prepend('<a style="width: 75%; margin: 10px auto; display: block; text-align: center;" href="https://tishonator.com/product/tpsychology" class="button-primary" target="_blank">{premium-get}</a>'.replace( '{premium-get}', customBtns.proget ) );
	$('.wp-full-overlay-sidebar-content').prepend('<a style="width: 75%; margin: 10px auto; display: block; text-align: center;" href="https://tishonator.com/demo/tpsychology" class="button" target="_blank">{premium-demo}</a>'.replace( '{premium-demo}', customBtns.prodemo ) );
});
