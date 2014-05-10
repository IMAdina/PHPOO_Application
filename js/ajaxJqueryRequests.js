$(document).ready(function() {
$(document).keypress(function(e) {
        if (e.keyCode == 13){
             e.preventDefault();
$.ajax({
url: 'scripts/sonBg.php',
        type: 'POST',
        data: {touche: 'enter'},
        dataType: 'html',
        success: applicationEtSon,
        });
        } else {
             e.preventDefault();
$.ajax({
url: 'scripts/sonBg.php',
        type: 'POST',
        data: {touche: 'none'},
        dataType: 'html',
        success: applicationSansSon,
        });
        }

});
        function applicationEtSon(result)
            {
                $(result).appendTo('.son');
            }
        
        function applicationSansSon(result)
            {
                $('.son').html(result);
            }
});

