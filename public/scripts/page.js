
$('#sendPageReport').click(() => {

    $.ajax({
        url: '/send_page_report',
        method: 'POST',
        data: $('form#pageReport').serialize(),
        success: (response) => {
            if (response == "error") {
                console.error("Error sending page report");
                $('#pageReport').hide();
                $('#sendPageReport').hide();
                $('#pageReportError').show();
                return;
            }
            $('#pageReport').hide();
            $('#sendPageReport').hide();
            $('#pageReportSuccess').show();
        },
        error: (error) => {
            console.error("Error sending page report", error);
            $('#pageReport').hide();
            $('#sendPageReport').hide();
            $('#pageReportError').show();
        }
    });

});


$('#sendCategoryReport').click(() => {

    $.ajax({
        url: '/send_category_report',
        method: 'POST',
        data: $('form#categoryReport').serialize(),
        success: (response) => {
            if (response == "error") {
                console.error("Error sending category report");
                $('#categoryReport').hide();
                $('#sendCategoryReport').hide();
                $('#categoryReportError').show();
                return;
            }
            $('#categoryReport').hide();
            $('#sendCategoryReport').hide();
            $('#categoryReportSuccess').show();
        },
        error: (error) => {
            console.error("Error sending category report", error);
            $('#categoryReport').hide();
            $('#sendCategoryReport').hide();
            $('#categoryReportError').show();
        }
    });

});


$('.metadataToggle').click(() => {
    $('.metadataToggle').toggleClass("down");
});