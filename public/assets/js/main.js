$(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
        $(this).toggleClass('active');
    });
    $("#addForm").submit(function (e) {
        //disable the submit button
        $('#add_modal_submit').attr("disabled", true);
        $('#add_modal_submit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading.....' );
        return true;
    });
    $("#editForm").submit(function (e) {
        //disable the submit button
        $('#edit_modal_submit').attr("disabled", true);
        $('#edit_modal_submit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading.....' );
        return true;
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })

});