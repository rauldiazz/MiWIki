
var requireRefreshOnLogout = true;

var orderCriterion = "creation_time";
var selectedCategory = 0;

function filterByTerm() {
  var value = $("#termFilter").val().toLowerCase();
  $("#listOfPages li").filter(function () {
    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
  });
  // Check if all elements are hidden
  if ($("#listOfPages li:visible").length === 0) {
    if ($("#emptyMessage").length === 0) {
      var message = $("<p>").attr("id", "emptyMessage").text("No matches found.").css("font-style", "italic");
      $("#listOfPages").append(message);
    }
  } else {
    $("#emptyMessage").remove();
  }
}

function invertListOrder() {
  // We change the symbol of the button
  var $button = $("#invertButton i");
  $button.toggleClass("bi-sort-up bi-sort-down");
  // We change the order of the list
  var $list = $("#listOfPages");
  var $items = $list.find("li");
  for (var i = 0; i < $items.length; i++) {
    $list.prepend($items[i]);
  }
}

function updateCriterion(criterion) {
  orderCriterion = criterion;
  getMyPages();
}

function updateCategory() {
  selectedCategory = $('#categories').val();
  getMyPages();
}

function getMyPages() {

  switch (orderCriterion) {
    case 'creation_time':
      params = {'criterion': 'created_at'};
      break;

    case 'modification_time':
      params = {'criterion': 'updated_at'};
      break;

    case 'alphabetical':
      params = {'criterion': 'title'};
      break;

    default:
      params = {};
      break;
  }

  if (selectedCategory > 0) {
    params['category'] = selectedCategory;
  }

  $.ajax({
    url: '/get_my_pages',
    type: 'GET',
    data: params,
    success: (response) => {
      if (response == "error") {
        console.error("Could not get my pages list", error);
        $('#listOfPagesWrapper').html('No pages found');
        return;
      }
      myPages = JSON.parse(response);
      if (myPages.length == 0) {
        $('#listOfPagesWrapper').html('There are no entries found with these criteria...');
      }
      else {
        content = '<ol id="listOfPages">';
        myPages.forEach((page) => {
          content += `<li><a href="/pages/${page.id}">${page.title}</a> <i class="bi bi-link-45deg"></i> </li>`;
        })
        content += '</ol>'
        $('#listOfPagesWrapper').html(content);
      }
    },
    error: (error) => {
      console.error("Could not get my pages list", error);
      $('#listOfPagesWrapper').html('No pages found');
    }
  })
}

$('#changePassword').submit(function (event) {

    event.preventDefault();
    $('#password-success').hide();
    $('#password-error').hide();

    let currentPassword = $("#current-password").val();
    let passwordInput = $("#new-password").val();
    let repPaswordInput = $("#confirm-password").val();

    $.ajax({
        url: '/update_password',
        type: 'POST',
        data: {
            currentPassword: currentPassword,
            newPassword: passwordInput,
            confirmNewPassword: repPaswordInput
        },
        success: function (response) {
    
            if (response =="errorCurrentPassword") {

                $('#password-error').html("Current password is not correct");
                $('#password-error').show();

                $("#current-pasword").val("");
                $("#new-pasword").val("");
                $("#confirm-pasword").val("");
                return;

            }

            if (response == "errorRequierements") {
                $('#password-error').html("Password does not meet requirements");
                $('#password-error').show();

                $("#current-pasword").val("");
                $("#new-pasword").val("");
                $("#confirm-pasword").val("");
                return;
            }
            if (response == "errorMatch") {

                $('#password-error').html("Introduced passwords are not equal");
                $('#password-error').show();

                $("#current-pasword").val("");
                $("#new-pasword").val("");
                $("#confirm-pasword").val("");
                return;
            }
           
            if(response=="error"){
                $('#password-error').html("Error updating password");
                $('#password-error').show();
    
                $("#current-pasword").val("");
                $("#new-pasword").val("");
                $("#confirm-pasword").val("");
                return;
            }

   

            $('#password-success').html("Success updating password");
            $('#password-success').show();

            $("#current-password").val("");
            $("#new-password").val("");
            $("#confirm-password").val("");

            return;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Error changing password: " + errorThrown);
            console.log("Status code: " + jqXHR.status);
            console.log("Response text: " + jqXHR.responseText);

            $('#password-error').html("Error verifying current password");
            $('#password-error').show();


            $("#current-pasword").val("");
            $("#new-pasword").val("");
            $("#confirm-pasword").val("");

            location.href = '/';
            return;
        }
    });

});


$(document).ready(() => {
  getMyPages();
})
