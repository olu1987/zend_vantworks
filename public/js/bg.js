$(document).ready(function(){
	if($('.home-slider').length){
		var home_slider=setInterval(function(){
			var $e=$('.home-slider'),
				$c=$e.find('li:visible'),
				$n=$c.next();
			if($n.length===0){$n=$e.find('li').eq(0);}
			$c.css('z-index',0).fadeOut(5);
			$n.css('z-index',1).fadeIn(10);
		},8000);
	}
});