
$(document).ready(function () {
    GetDocNo();

    $('[data-toggle="tooltip"]').tooltip();
    $('#body').bind('touchmove', false);

    /*=========================================================================*/
    $("#deptID").on("change", function () {
        var $deptID = $(this).val();
        var selText = $(this).find("option:selected").text();

        $("#getDeptName").val(selText);

        $.ajax({
            type: "POST",
            data: { deptID: $deptID },
            url: './controllers/get_location.php'
        }).done(function (data) {
            $("#locaID").html(data)
        });
    });

    $("#locaID").on("change", function () {
        var selText = $(this).find("option:selected").text();

        $("#getLocaName").val(selText);
    });

    $("#FrmSpaSurvey").on("submit", function (e) {
        e.preventDefault();

        var numRows = $("input:radio:checked").length;

        if (numRows <= 0) {
            swal("", "Please enter your rating / โปรดให้คะแนน", "error");
        } else {
            $.ajax({
                method: 'POST',
                url: './controllers/insert_survey.php',
                data: {
                    docNo: $('#DocNo').text(),
                    emp: $('#EmpName').val(),
                    comment: $('#Comments').val(),
                }
            }).done(function (data) {
                $('input:radio:checked').each(function () {
                    var params = {
                        docNo: $('#DocNo').text(),
                        qId: $(this).attr('name'),
                        deptId: $("#deptIDs").text().trim(),
                        locaId: $("#locaIDs").text().trim(),
                        rating: $(this).val()
                    }

                    $.ajax({
                        type: 'POST',
                        url: './controllers/insert_survey_detail.php',
                        data: $.param(params),
                        success: function (data) {
                            if (data.status === "success") {
                                swal("Thank you / ขอบคุณ", "", "success");
                                $('input[type=radio]').prop('checked', false);
                                $('#EmpName').prop('selectedIndex', 0);
                                $('#Comments').val('');
                                GetDocNo();
                            }
                        }
                    });
                });
            }).fail(function (jqXHR, textStatus, errorThrown) {
                swal("", "Something went wrong, please contact IT", "error");
            });

        }

    });

});

function GetDocNo() {
    $.ajax({
        method: 'GET',
        url: './controllers/json_get_docno.php',
        dataType: 'JSON',
    }).done(function (data) {
        $('#DocNo').text(data);
    });
}

$(document).ajaxStart(function () {
    $.blockUI({
        message: '\n\
                    <span style="font-size: 16px">Processing...</span>\n\
                    <div class="progress" style="border-radius: 0px; margin-top: 5px;">\n\
                        <div class="progress-bar progress-bar-striped active" \n\
                            role="progressbar"\n\
                            style="width:100%;">\n\
                        </div>\n\
                    </div>'
    });
}).ajaxStop($.unblockUI);

