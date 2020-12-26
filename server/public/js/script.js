var _ = function(qs) {
    var ele = document.querySelector(qs);
    return ele;
}

var from_now = function(oldTime) {
    var msPerMinute = 60 * 1000;
    var msPerHour = msPerMinute * 60;
    var msPerDay = msPerHour * 24;
    var msPerMonth = msPerDay * 30;
    var msPerYear = msPerDay * 365;
    var d = new Date();
    var now = d.getTime();
    var n = d.getTimezoneOffset();
    var elapsed = now - (oldTime - (60000*n));
    var val = 0;

    if (elapsed < msPerMinute) {
    val = Math.round(elapsed/1000);
    return val + ' second'+_s(val)+' ago';
    }

    else if (elapsed < msPerHour) {
    val = Math.round(elapsed/msPerMinute);
    return val + ' minute'+_s(val)+' ago';
    }

    else if (elapsed < msPerDay ) {
    val = Math.round(elapsed/msPerHour);
    return val + ' hour'+_s(val)+' ago';
    }

    else if (elapsed < msPerMonth) {
    val = Math.round(elapsed/msPerDay);
    return val + ' day'+_s(val)+' ago';
    }

    else if (elapsed < msPerYear) {
    val = Math.round(elapsed/msPerMonth);
    return  val + ' month'+_s(val)+' ago';
    }

    else {
    val = Math.round(elapsed/msPerYear);
    return val + ' year'+_s(val)+' ago';
    }

    function _s(val) {
    if(val < 2) return '';
    else return 's';
    }
}
