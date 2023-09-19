
$('#editor').submit(function (event) {

    event.preventDefault();
    
    let titleInput = $("#title").val();
    let contentInput = $("#content").val();
    let categoryInput = $("#categories").val();

    $.ajax({
        url: '/create_page',
        type: 'POST',
        data: {
            title: titleInput,
            content: contentInput,
            categories: categoryInput
        },
        success: function (response) {
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