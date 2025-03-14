jQuery(function($){

	// AdPacks CSS
	var css = '\
		#bsaHolder{				right: 25px;position: absolute;	top: 0;	width: 345px;z-index: 10;}\
		#bsaHolder span{		text-shadow:1px 1px 0 #fff;}\
		#bsap_aplink,\
		#bsap_aplink:visited{	bottom: 10px;color: #aaa;font: 11px arial, sans-serif;position: absolute;right: 14px;border:none;}\
		#bsaHolder .bsa_it_p{	display:none;}\
		#bsaHolder .bsa_it_ad{	background: -moz-linear-gradient(#F3F3F3, #FFFFFF, #F3F3F3) repeat scroll 0 0 transparent; background: -webkit-gradient(linear,0% 0%,0% 100%,color-stop(0, #f3f3f3),color-stop(0.5, #fff),color-stop(1, #f3f3f3)); background-color:#f4f4f4;\
								border-color: #fff;overflow: hidden;padding: 10px 10px 0;-moz-box-shadow: 0 0 2px #999;-webkit-box-shadow: 0 0 2px #999;box-shadow: 0 0 2px #999;\
								-moz-border-radius: 0 0 4px 4px;-webkit-border-radius: 0 0 4px 4px;border-radius: 0 0 4px 4px;}\
		#bsaHolder img{			display:block;border:none;}\
		#bsa_closeAd{			width:15px;height:15px;overflow:hidden;position:absolute;top:10px;right:11px;border:none !important;\
								text-decoration:none !important;background:url("http://cdn.tutorialzine.com/misc/enhance/x_icon.png") no-repeat;}\
		#bsa_closeAd:hover{		background-position:left bottom;}\
	';

	addStyle(css);

	// AdPacks markup
	$('body').prepend('<div id="bsaHolder">\
    	<div id="bsap_1259038" class="bsarocks bsap_fe75131c335e3bd42585d699208c59c8"></div>\
	    <a href="http://adpacks.com" id="bsap_aplink">via Ad Packs</a>\
	</div>');

	$('<a>',{
		href:'',
		id:'bsa_closeAd',
		title:'Hide this Ad!',
		click:function(){
			$(this).parent().remove();
			return false;
		}
	}).appendTo('#bsaHolder');
	

	// AdPacks.com ad code
	(function(){
	  var bsa = document.createElement('script');
		 bsa.type = 'text/javascript';
		 bsa.async = true;
		 bsa.src = '//s3.buysellads.com/ac/bsa.js';
	  (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild(bsa);
	})();
	
	// Show sharing buttons
	setTimeout(function(){
		
    	var twitter = '<iframe allowtransparency="true" frameborder="0" scrolling="no" src="http://platform.twitter.com/widgets/tweet_button.html?url={URL}&amp;via=tutorialzine&amp;count=horizontal" ></iframe>';
		var facebook = '<iframe src="http://www.facebook.com/plugins/like.php?href={URL}&amp;layout=button_count&amp;show_faces=false&amp;width=450&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" allowtransparency="true"></iframe>';
		
		var URL = $('#tzine-download').attr('href');
		URL = encodeURIComponent(URL);
		
		$('#tzine-actions').prepend(twitter.replace('{URL}',URL))
						   .prepend(facebook.replace('{URL}',URL));
	},2500);
	
	function addStyle(str){
		var style = document.createElement('style');
	
		style.setAttribute("type", "text/css");
		if (style.styleSheet) {   // IE
			style.styleSheet.cssText = str;
		} else {                // the world
			style.appendChild(document.createTextNode(str));
		}
		
		jQuery('head').append(style);
		$('html').css('background-attachment','scroll');
	}
});