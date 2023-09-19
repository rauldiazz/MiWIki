
$('#editor').submit(function (event) {

    event.preventDefault();

    let titleInput = $("#title").val();
    let contentInput = $("#content").val();
    let categoryInput = $("#categories").val();

    $.ajax({
        url: '/edit_page',
        type: 'POST',
        data: {
            page_id: page_id,
            title: titleInput,
            content: contentInput,
            categories: categoryInput
        },
        success: function (response) {
            console.log(response);
            location.href='/pages/'+ response;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Error sending text: " + errorThrown);
            console.log("Status code: " + jqXHR.status);
            console.log("Response text: " + jqXHR.responseText);

            alert("Error uploading page");
            location.href='/';
        }
    });

});

$(document).ready(() => {
    $('#title').val(page_title);
    $('#content').val(page_content);
    $('#categories').val(page_category);
    updatePreview();
})