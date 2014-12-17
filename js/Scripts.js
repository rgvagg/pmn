//to get the query string values on the current page! (in javascript!)
function getQueryStrings() {
		var assoc = {};
		var decode = function (s) { return decodeURIComponent(s.replace(/\+/g, " ")); };
		var queryString = location.search.substring(1);
		var keyValues = queryString.split('&');

		for (var i in keyValues) {
			var key = keyValues[i].split('=');
		if (key.length > 1) {
			assoc[decode(key[0])] = decode(key[1]);
		}
	}
	return assoc;
}

//this is the function to change the active state of the list on the LHS
function changeActiveState(item) {
    $('a.active').removeClass('active');
    $(item).addClass('active');
}

function showDiv(item) {
    var arr = $('.divsMain');
    var ob = $(item);

    for (var i = 0; i < arr.length; i++) {
        $(arr[i]).hide(1);
        $(arr[i]).css({
            top: '1000px'
        });
    }
    //ob.show('fast');
    ob.show(1);
    ob.animate({
        top: '0px'
    }, 300);
}

