
const converter = new showdown.Converter({ parseImgDimensions: true });

function updatePreview() {
  let content = $('#content').val();
  let preview = converter.makeHtml(content);
  $('#preview').html(preview);
}

function loadFile() {

  let inputFile = $('#fileInp').prop('files');

  if (inputFile.length != 1) {
    alert('Please choose only one file');
    return;
  }
  markdown = inputFile[0];

  let reader = new FileReader();
  reader.readAsText(markdown);
  reader.onload = function () {
    $('#content').val(reader.result);
    let fileName = inputFile[0].name;
    $('#fileName').val(fileName);
    updatePreview();
  };

  reader.onerror = function () {
    console.log(reader.error);
  };

}

$('#content').on('input', updatePreview);

$('#reset-fields').click(function () {
  $('#editor').trigger('reset');
  $('#preview').html('');
})

var requireRefreshOnLogout = true;

function toggleNewCategoryField() {
  var button = $("#toggleNewCategory");
  var field = $('#newCategoryField');
  if (button.text() == "+") {
    button.text("-");
    field.show(duration = 500);
  } else {
    button.text("+");
    field.hide(duration = 500);
  }
}


function createCategory() {
  var categoryName = $("#newCategoryInput").val();
  if (categoryName) {
    // If the user entered a name, send an AJAX request to create the new category
    $.ajax({
      url: '/create_category',
      method: 'POST',
      dataType: 'json',
      data: { name: categoryName },
      success: function (data) {
        // Add the new category to the select element and select it
        var newOption = document.createElement("option");
        newOption.value = data.id;
        newOption.text = data.name;
        document.getElementById("categories").appendChild(newOption);
        newOption.selected = true;
        toggleNewCategoryField();
        $("#newCategoryInput").val("")
      },
      error: function (xhr, status, error) {
        // $("#errorMessage").toggle();
        alert("Error creating category.");
        console.error("Error creating category", error);
      }
    });
  }
}