
var orderCriterion = "creation_time";
var selectedCategory = 0;


function updateCriterion(criterion) {
    orderCriterion = criterion;
    querySearch($('#search-prompt').val());
}

function updateCategory() {
    selectedCategory = $('#categories').val();
    querySearch($('#search-prompt').val());
}

function invertListOrder() {
    // We change the symbol of the button
    var $button = $("#invertButton i");
    $button.toggleClass("bi-sort-up bi-sort-down");
    // We change the order of the list
    var $list = $("#search-results");
    var $items = $list.find("li");
    var $seps = $list.find("hr");
    for (var i = 0; i < $items.length; i++) {
        $list.prepend($items[i]);
        $list.prepend($seps[i]);
    }
}


function querySearch(prompt) {

    // If prompt text does not have more than 1 letter, it will not perform any query
    if (prompt.length < 2) {
        $('#search-results-container').hide();
        $('#search-loading').hide()
        return;
    }

    switch (orderCriterion) {
        case 'creation_time':
            params = { 'criterion': 'created_at' };
            break;

        case 'modification_time':
            params = { 'criterion': 'updated_at' };
            break;

        case 'alphabetical':
            params = { 'criterion': 'title' };
            break;

        default:
            params = {};
            break;
    }

    if (selectedCategory > 0) {
        params['category'] = selectedCategory;
    }

    params['prompt'] = prompt;

    $.ajax({
        url: '/search',
        type: 'POST',
        data: params,
        success: function (response) {

            var search_results = JSON.parse(response);
            if (search_results.length > 0) {
                var resultList = [];
                search_results.forEach(entry => {
                    var bStart = entry.title.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase().indexOf(prompt.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase());
                    var bEnd = bStart + prompt.length;
                    if (entry.img == '') {
                        imgUrl = '/public/assets/img_not_found.jpg';
                    }
                    else {
                        imgUrl = entry.img;
                    }
                    resultList.push(`
                        <li class="entryContainer">
                            <a href="/pages/${entry.id}" class="row">
                                <img src="${imgUrl}" class="ml-4 mr-1 my-auto entry-img">
                                <div class="col">
                                    <h2 class="entryTitle">${entry.title.slice(0, bStart)}<b>${entry.title.slice(bStart, bEnd)}</b>${entry.title.slice(bEnd, entry.title.length)}</h2>
                                    <p>Category: ${entry.category_name}</p>
                                    <p>Updated at ${entry.updatedAt} by ${entry.updatedBy}</p>
                                </div>
                            </a>
                        </li>
                    `);
                });
                $('#search-results').html(resultList.join('<hr class="entrySep">'));
                $('#search-results-container').show();
            }
            else {
                $('#search-results').html('<p style="font-style: italic;">No matches found.</p>');
                $('#search-results-container').show();
            }
            $('#search-loading').hide()
        },
        error: function (response) {
            console.log("Error on search query: ", response);
            $('#search-results').html('');
            $('#search-results-container').hide();
            $('#search-loading').hide()
        }
    });

}

var timer_id;   // To prevent doing a query every time keyUp event is triggered
$('#search-prompt').on('input', function () {
    var prompt = $(this).val();
    if (prompt.length > 0) {
        $('#reset-prompt').prop("disabled", false);
    }
    else {
        $('#reset-prompt').prop("disabled", true);
    }
    $('#search-loading').show();
    $('#search-results').html('');
    $('#search-results-container').show();
    if ($(this).data('last_prompt') != prompt) {
        $(this).data('last_prompt', prompt);
        clearTimeout(timer_id);
        timer_id = setTimeout(() => querySearch(prompt), 500);
    };
});

function updateResetPromptButton() {
    $('#search-prompt').val('');
    querySearch('');
    $('#reset-prompt').prop("disabled", true);
}