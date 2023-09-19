
var requireRefreshOnLogout = true;

function updateTablesVisualization() {
    if ($("#page-report-table").is(":empty")) {
        $("#page-reports-empty").show();
        $("#page-reports-cont").hide();
    } else {
        $("#page-reports-empty").hide();
        $("#page-reports-cont").show();
    }
    if ($("#category-report-table").is(":empty")) {
        $("#category-reports-empty").show();
        $("#category-reports-cont").hide();
    } else {
        $("#category-reports-empty").hide();
        $("#category-reports-cont").show();
    }
}

function deletePage(page_id) {

    $.ajax({
        url: '/admin/delete_page',
        method: 'GET',
        data: {
            'id': page_id,
        },
        success: function (response) {
            if (response == "error") {
                alert("Error: could not delete page");
                return;
            }
            fillPageReports();
            $('#pageToBeDeleted').html('');
            $('#pageToBeDeleted').attr('href', '');
            $('#deletePageBtn').click(() => _);
            $('#deletePage').modal('hide');
        },
        error: function (xhr, status, error) {
            console.error("Error deleting page", error);
            alert("Error: could not delete page");
        }
    });
}

function deletePageModal(page_id, page_title) {
    setTimeout(updateTablesVisualization, 500);

    $('#pageToBeDeleted').html(page_title);
    $('#pageToBeDeleted').attr('href', '/pages/' + page_id);
    $('#deletePageBtn').click(() => deletePage(page_id));
    $('#deletePage').modal('show');
}

function deleteCategory(category_id) {

    $.ajax({
        url: '/admin/delete_category',
        method: 'GET',
        data: {
            'id': category_id,
        },
        success: function (response) {
            if (response == "error") {
                alert("Error: could not delete category");
                return;
            }
            fillCategoryReports();
            $('#categoryToBeDeleted').html('');
            $('#categoryToBeDeleted').attr('href', '');
            $('#deleteCategoryBtn').click(() => _);
            $('#deleteCategory').modal('hide');
        },
        error: function (xhr, status, error) {
            console.error("Error deleting category", error);
            alert("Error: could not delete category");
        }
    });
}

function deleteCategoryModal(category_id, category_name) {
    setTimeout(updateTablesVisualization, 500);

    $('#categoryToBeDeleted').html(category_name);
    $('#deleteCategoryBtn').click(() => deleteCategory(category_id));
    $('#deleteCategory').modal('show');
}

function discardPageReport(reportId) {

    setTimeout(updateTablesVisualization, 500);


    $.ajax({
        url: '/admin/discard_page_report',
        method: 'GET',
        data: {
            'report_id': reportId,
        },
        success: function (response) {
            if (response == "error") {
                alert("Error: could not discard page report");
                return;
            }
            fillPageReports();
        },
        error: function (xhr, status, error) {
            console.error("Error discarting page report", error);
            alert("Error: could not discard page report");
        }
    });
}

function discardCategoryReport(reportId) {

    setTimeout(updateTablesVisualization, 500);


    $.ajax({
        url: '/admin/discard_category_report',
        method: 'GET',
        data: {
            'report_id': reportId,
        },
        success: function (response) {
            if (response == "error") {
                alert("Error: could not discard category report");
                return;
            }
            fillCategoryReports();
        },
        error: function (xhr, status, error) {
            console.error("Error discarting category report", error);
            alert("Error: could not discard category report");
        }
    });
}

function fillPageReports() {

    $('#page-report-table').html('');

    $.ajax({
        url: '/admin/get_page_reports',
        type: 'GET',
        success: function (response) {
            if (response == "error") {
                alert("Error: could not get page reports");
                $('#page-report-table').html('');
                return;
            }
            tableHtml = '';
            reports = JSON.parse(response);
            reports.forEach((report) => {
                tableHtml +=
                    `
                    <tr>
                        <th scope="row">${report.id}</th>
                        <td><a href="/pages/${report.page_id}" target="_blank">${report.page_title}</a></td>
                        <td>${report.description}</td>
                        <td>${report.user}</td>
                        <td>${report.created_at}</td>
                        <td class="d-flex flex-wrap justify-content-between">
                            <button onclick="discardPageReport(${report.id})" class="btn btn-sm btn-secondary flex-shrink-0">Discard</button>
                            <button onclick="deletePageModal(${report.page_id}, '${report.page_title}')" class="btn btn-sm btn-danger flex-shrink-0">Delete page</button>
                        </td>
                    </tr>

                    `;
            });
            $('#page-report-table').html(tableHtml);
        },
        error: function (xhr, status, error) {
            console.error("Error obtaining page reports", error);
            alert("Error: could not get page reports");
            $('#page-report-table').html('');
        }
    });
}

function fillCategoryReports() {

    $('#category-report-table').html('');

    $.ajax({
        url: '/admin/get_category_reports',
        method: 'GET',
        success: function (response) {
            if (response == "error") {
                alert("Error: could not get category reports")
                $('#category-report-table').html('');
                return;
            }

            tableHtml = '';
            reports = JSON.parse(response);
            reports.forEach((report) => {
                tableHtml +=
                    `
                    <tr>
                        <th scope="row">${report.id}</th>
                        <td>${report.category_name}</td>
                        <td>${report.description}</td>
                        <td>${report.user}</td>
                        <td>${report.created_at}</td>
                        <td class="d-flex flex-wrap justify-content-between">
                            <button onclick="discardCategoryReport(${report.id})" class="btn btn-sm btn-secondary flex-shrink-0">Discard</button>
                            <button onclick="deleteCategoryModal(${report.category_id}, '${report.category_name}')" class="btn btn-sm btn-danger flex-shrink-0">Delete category</button>
                        </td>
                    </tr>

                    `;
            });
            $('#category-report-table').html(tableHtml);
        },
        error: function (xhr, status, error) {
            console.error("Error obtaining category reports", error);
            alert("Error: could not get category reports")
            $('#category-report-table').html('');
        }
    });

}

$(document).ready(() => {

    fillPageReports();
    fillCategoryReports();
    setTimeout(updateTablesVisualization, 500);

});