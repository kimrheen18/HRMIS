var SessionTimeout = function () {

    var handlesessionTimeout = function () {
        $.sessionTimeout({
            title: 'Session Timeout Notification',
            message: 'Your session is about to expire.',
            keepAliveUrl: '../login/timeoutkeepalive',
            redirUrl: '../logout',
            logoutUrl: '../logout',
            warnAfter: 600000, //warn after 5 seconds
            redirAfter: 700000, //redirect after 10 secons, (1500/second)
            ignoreUserActivity: true,
            countdownMessage: 'Redirecting in {timer} seconds.',
            countdownBar: true
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            handlesessionTimeout();
        }
    };

}();

jQuery(document).ready(function() {    
   SessionTimeout.init();
});