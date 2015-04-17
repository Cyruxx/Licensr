$(document).ready(function () {

    // Select boxes
    $('select').select2({
        minimumResultsForSearch: Infinity
    });

    $('form').trigger('reset');
    var fileInput = $('.fileInput');
    var textInput = $('.fileText');

    // For firefox element state after page refresh
    //copyrightBtn.attr('disabled', 'disabled');

    // File Uploader
    fileInput.on('change', function (e) {
        console.log($(this).val());
        var input = $(this);
        var fileNames = [];
        $.each(input.get(0).files, function(key, file) {
            fileNames.push(file.name);
        });

        console.log(fileNames);
        var fileString = fileNames.join(', ');

        textInput.val(fileString);
    });
});