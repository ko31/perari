//var sendForm = function(){
//
//	var my-name = $('#my-name').val();
//    if (my-name.length == 0) {
//        alert('Input your name.');
//        $('#my-name').focus();
//        return false;
//    }
//
//	var my-country = $('#my-country').val();
//    if (my-country.length == 0) {
//        alert('Input your country.');
//        $('#my-country').focus();
//        return false;
//    }
//
//	var my-message = $('#my-message').val();
//    if (my-message.length == 0) {
//        alert('Input your message.');
//        $('#my-message').focus();
//        return false;
//    }
//
//    $('#form1').submit();
//
//    return true;
//};

$(function(){
    $('#btn-send').on(Gumby.click, function(e) {

    	var name = $('#my-name').val();
        if (name.length == 0) {
            alert('Input your name');
            $('#my-name').focus();
            return false;
        }
    
    	var country = $('#my-country').val();
        if (country.length == 0) {
            alert('Input your country');
            $('#my-country').focus();
            return false;
        }
    
    	var message = $('#my-message').val();
        if (message.length == 0) {
            alert('Input your message');
            $('#my-message').focus();
            return false;
        }
    
        $('#form1').submit();
    
        return true;
	});
});

