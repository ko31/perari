navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

var myTimer;
var myStream;
//var peer = new Peer({key: '9rs7o9xm5jbdquxr'});
//var peer = new Peer({host:'perari-peerserver.herokuapp.com', secure:true, port:443, key: 'peerjs', debug: 1})
var peer = new Peer({host:'skyway.io', secure:true, port:443, key: '9d9b7976-b55a-40ad-b903-6b9043c8530b', debug: 1})

var setOthersStream = function(stream){
	$('#others-video').prop('src', URL.createObjectURL(stream));
};

var setMyStream = function(stream){
	console.log("[setMyStream]");
	myStream = stream;
	$('#my-video').prop('src', URL.createObjectURL(stream));
	var id = $('#peer-id').val();
    if (id) {
    	console.log("[start]"+id);
        start(id);
        startProgress();
        progressNew();
    }
};

var callOthersStream = function(other_peer_id){
    var call = peer.call(other_peer_id, myStream);
//    call.on('stream', setOthersStream);
};

var start = function(id){
    $.ajax({
        type: "POST",
        url: "/connections/progress",
        data: {
            peer_id: id,
            name: $('#my-name').text(),
            country: $('#my-country').text(),
            message: $('#my-message').text()
        }
        }).done(function( msg ) {
            console.debug(msg);
    });
};

var progress = function(id, answer){
console.debug("[progress]answer="+answer);
    $.ajax({
        type: "POST",
        url: "/connections/progress",
        data: {
            peer_id: id,
            answer: answer,
        }
        }).done(function( json ) {
            if (typeof json.status !== "undefined") {
                switch (json.status) {
                    case 0:
                        progressNew(json); 
                        break;
                    case 1:
                        progressMatching(json); 
                        break;
                    case 2:
                        progressMatchingOK(json); 
                        break;
                    case 3:
                        progressMatchingNG(json); 
                        break;
                    case 4:
                        progressConnect(json); 
                        break;
                }
            } else {
                //
    	        console.log("[progress]"+json);
            }
    	    console.debug(json);
    });
};

var finish = function(id){
    $.ajax({
        type: "POST",
        url: "/connections/finish",
        data: {
            peer_id: id,
        }
        }).done(function( msg ) {
            console.debug(msg);
    });
};

var close = function(id){
    $.ajax({
        type: "POST",
        url: "/connections/close",
        data: {
            peer_id: id,
        }
        }).done(function( msg ) {
            console.debug(msg);
            startProgress();
            progressNew();
    });
};

var startProgress = function(){
    myTimer = setInterval(function(){
	    var id = $('#peer-id').val();
        progress(id, null);
        console.debug("[interval]");
    }, 3000);
};

var stopProgress = function(){
    clearInterval(myTimer);
};

var progressNew = function(){
    // change elements
    $('#modal1').addClass('active');
    $('#modal-search').show();
    $('#modal-found').hide();
    $('.answer-btn').show();
    $('.answer-msg').hide();
};

var progressMatching = function(json){
    // change elements
    $('#modal1').addClass('active');
    $('#modal-search').hide();
    $('#modal-found').show('slow');
    // set other 
    $('#other-name').text(json.name);
    $('#other-country').text(json.country);
    $('#other-message').text(json.message);
    // stop timer
    stopProgress();
};

var progressMatchingOK = function(json){
    // change elements
    $('.answer-btn').hide();
    $('.answer-msg').show('slow');
    // start timer
    startProgress();
};

var progressMatchingNG = function(json){
    // change elements
    $('.answer-btn').hide();
    $('.answer-msg').show('slow');
    // start timer
    startProgress();
};

var progressConnect = function(json){
    // change elements
    $('#modal1').removeClass('active');
    // set other 
    $('#other-name2').text(json.name);
    $('#other-country2').text(json.country);
    $('#other-message2').text(json.message);
    // stop timer
    stopProgress();
    // call other
    callOthersStream(json.other_peer_id);
};

//var isJson = function(arg) {
//    arg = (typeof arg === "function") ? arg() : arg;
//    if (typeof arg  !== "string") {
//        return false;
//    }
//    try {
//        arg = (!JSON) ? eval("(" + arg + ")") : JSON.parse(arg);
//        return true;
//    } catch (e) {
//        return false;
//    }
//};

peer.on('open', function(id){
	console.log("[open]"+id);
	$('#peer-id').val(id);
//	$('#peer-id-label').text(id);
});

peer.on('call', function(call){
	console.log("[call]");
	call.answer(myStream);
	call.on('stream', setOthersStream);
});

$(function(){
	navigator.getUserMedia({audio: true, video: true}, setMyStream, function(){});
	$('#call').on('click', function(){
		var call = peer.call($('#others-peer-id').val(), myStream);
		call.on('stream', setOthersStream);
	});

//TODO:ページ離脱時に終了ステータスに更新したい
//    $(window).on("beforeunload", function(e){
//	    var id = $('#peer-id').val();
//        finish(id);
//        return "ページから離れようとしています"
//    });

    $('#btn-ok').on(Gumby.click, function(e) {
        var id = $('#peer-id').val();
        progress(id, 'OK');
    });
    
    $('#btn-ng').on(Gumby.click, function(e) {
        var id = $('#peer-id').val();
        progress(id, 'NG');
    });
    
    $('#modal1-cancel').on(Gumby.click, function(e) {
        var id = $('#peer-id').val();
        close(id);
    });

});

peer.on('error', function(e){
	console.log("[error]");
	console.log(e.message);
});
