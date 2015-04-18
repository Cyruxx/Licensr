$(document).ready(function () {

    // Select boxes
    $('select').select2({
        minimumResultsForSearch: Infinity
    });

    $('form').trigger('reset');
    var fileInput = $('.fileInput');
    var textInput = $('.fileText');
    var licenseInput = $('.licenseType');
    var projectInput = $('.projectInput');
    var projectName = $('.projectName');
    var contributors = $('.contributors');
    var licenseName = $('.licenseName');
    var contributorsInput = $('.contributorsInput');


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

    // Preview functions and events
    var licenses = ['MIT', 'Apache 2.0', 'GPL v2', 'GPL v3'];
    licenseInput.on('change', function (e) {
        var selectedInput = $(this).find('option:selected');

        licenseName.html(licenses[parseInt(selectedInput.val())]);
    });

    projectInput.on('keyup', function (e) {
        projectName.html($(this).val());

        if($(this).val().length == 0) {
            projectName.html('Licensr');
        }
    });

    contributorsInput.on('keyup', function (e) {
        contributors.html($(this).val());

        if($(this).val().length == 0) {
            contributors.html('Alex Mahrt');
        }
    });
});