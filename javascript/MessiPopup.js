// Parse URL Queries Method
(function($){
	$.getQuery = function( query ) {
		query = query.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
		var expr = "[\\?&]"+query+"=([^&#]*)";
		var regex = new RegExp( expr );
		var results = regex.exec( window.location.href );
		if( results !== null ) {
			return results[1];
			return decodeURIComponent(results[1].replace(/\+/g, " "));
		} else {
			return false;
		}
	};
})(jQuery);
 
// Document load
$(function(){
	if ($.getQuery('m')) {
                $.getScript("javascript/messi.min.js", function(){


        var message = $.getQuery('m');
        message = message.replace('+', ' ');
	var messi = new Messi(message, {title: 'Bericht van Filmpje'});
        });
        
        }

});



