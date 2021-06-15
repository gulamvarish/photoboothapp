/*****************************************************
**
**                SOCIALPIC JS
**
** Jquery for the socialpic jquery plugin
**
** Author: Andrew Hartnett
**   Date: November 2014
**
*****************************************************/

(function($){

function overlay($img, opts){
	var floating = opts.float || 'left';
	var rgba = opts.rgba || '38,47,49,0.8';
	var color = opts.color || '#ffffff';

	$img.wrap('<div class="wrap"></div>');

	$wrap = $img.parent();

	$wrap.css('float',floating);


	$overlay = $('<div>');
	$overlay.addClass('overlay');
	$overlay.css('background','rgba('+rgba+')');

	$links = $('<ul>');

	$overlay.append($links);

	$facebook = $('<li>')
	$facebook.html('<span class="socialclick facebook-share"><i class="fa fa-lg fa-facebook"></i></span>');
	$twitter = $('<li>')
	$twitter.html('<span class="socialclick twitter-share"><i class="fa fa-lg fa-twitter"></span>');
	$google = $('<li>')
	$google.html('<span class="socialclick google-share"><i class="fa fa-lg fa-google-plus"></i></span>');
	$pinterest = $('<li>')
	$pinterest.html('<span class="socialclick pinterest-share"><i class="fa fa-lg fa-pinterest"></i></span>');

	$download = $('<li>')
	$download.html('<span class="socialclick download"><i class="fa fa-lg fa-download"></i></span>');

	$('span.socialclick').css('color',color);

	$links.append($facebook);
	$links.append($twitter);
	$links.append($google);
	$links.append($pinterest);
	$links.append($download);


	$overlay.css('height',$img.attr('height'));
	$overlay.css('width',$img.attr('width'));

	$links.css('margin-top', (parseFloat($img.attr('height'))/2.1)+'px');


	$overlay.css('margin-top',$img.css('marginTop'));
	$overlay.css('margin-bottom',$img.css('marginBottom'));
	$overlay.css('margin-left',$img.css('marginLeft'));
	$overlay.css('margin-right',$img.css('marginRight'));

	$overlay.css('padding-top',$img.css('paddingTop'));
	$overlay.css('padding-bottom',$img.css('paddingBottom'));
	$overlay.css('padding-left',$img.css('paddingLeft'));
	$overlay.css('padding-right',$img.css('paddingRight'));

	//Add links
	$img.before($overlay);
}

$.fn.socialpic = function(opts){

	var opts = opts || [];
	$(this).each(function(){
		overlay($(this), opts);
	});

	return this;
}



}(jQuery));

$(function(){
	$('body').on('click', 'span.socialclick', function(){
			var url       = $(this).closest('div.wrap').find('img').attr('downloadurl');
			var fullurl   = $(this).closest('div.wrap').find('img').attr('downloadurl');
			var imagename = $(this).closest('div.wrap').find('img').attr('name');

			if($(this).hasClass('facebook-share')){
				window.open('https://www.facebook.com/sharer/sharer.php?u='+url, 'Share Facebook');
			}

			if($(this).hasClass('twitter-share')){
				window.open('http://twitter.com/share?url='+url, 'Share Twitter', config='height=300, width=500');
			}

			if($(this).hasClass('google-share')){
				window.open('https://plus.google.com/share?url='+url, 'Share Google +', config='height=300, width=500');
			}

			if($(this).hasClass('pinterest-share')){
				window.open('http://www.pinterest.com/pin/create/button/?url='+url+'&media='+url+'&description=Currently%20Inspired%20By', 'Share Pinterest', config='height=300, width=500');
			}

			if($(this).hasClass('download')){

				var a = document.createElement('a');
					a.href = fullurl;
					a.download = imagename;
					document.body.appendChild(a);
					a.click();
					document.body.removeChild(a);

				//$("<a>").attr("href", "+url+").attr("download", "img.png").appendTo("body").click().remove();
				
			}

	});
});