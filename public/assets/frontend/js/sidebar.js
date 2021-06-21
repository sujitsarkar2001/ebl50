$(document).ready(function () {
    
    $(document).on('click', '.bars', function (e) {
        
        $('#sidebar').css('width', '230px')
    })
    $(document).on('click', '.close-btn i', function (e) {
        
        $('#sidebar').css('width', '0')
    })

});