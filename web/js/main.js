var Countdown;
$(function() {
    $(document).on("submit", "#form-step-1",
        function( event ){
            $.ajax({
                url: $('#form-step-1').attr('action'),
                type: 'POST',
                dataType: undefined,
                cache: false,
                data: $('#form-step-1').serialize()
            }).done(
                function( result ){
                    $('#register-container').html( result.response );
                }
            );
            return false;
        }
    );

    $(document).on("submit", "#form-step-2",
        function( event ){
            $.ajax({
                url: $('#form-step-2').attr('action'),
                type: 'POST',
                dataType: undefined,
                cache: false,
                data: $('#form-step-2').serialize()
            }).done(
                function( result ){
                    $('#register-container').html(result.response);
                    if (result.success) {
                        Countdown.Timer.stop();
                        $('#countdown').remove();

                    }
                }
            );
            return false;
        }
    );

    Countdown = new (function() {
        var $countdown,
            incrementTime = 70,
            currentTime = $.jStorage.get("countDownTimer") || 36000,
            updateTimer = function() {
                $countdown.html(formatTime(currentTime));
                if (currentTime == 0) {
                    Countdown.Timer.stop();
                    timerComplete();
                    return;
                }
                currentTime -= incrementTime / 10;
                if (currentTime < 0) {
                    currentTime = 0;
                    $.jStorage.deleteKey("countDownTimer");
                }
                $.jStorage.set("countDownTimer", currentTime);
            },
            timerComplete = function() {
                alert('Your time is over!');
            },
            init = function() {
                $countdown = $('#countdown');
                Countdown.Timer = $.timer(updateTimer, incrementTime, true);
            };
        $(init);
    });

});

// Common functions
function formatTime(time) {
    var min = parseInt(time / 6000),
        sec = parseInt(time / 100) - (min * 60),
        hundredths = parseInt( (time - (sec * 100) - (min * 6000)) / 10 );
    return parseInt(time / 100) + '.' + hundredths + ' seconds';
}
