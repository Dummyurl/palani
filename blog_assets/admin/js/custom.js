//update token
$("form").submit(function () {
    $("input[name='" + csfr_token_name + "']").val($.cookie(csfr_cookie_name));
});

//datatable
$(function () {
    $(document).ready(function () {
        $('#cs_datatable').DataTable({
            "order": [[0, "desc"]],
            "aLengthMenu": [[15, 30, 60, 100], [15, 30, 60, 100, "All"]]
        });
    });
});


//Flat red color scheme for iCheck
$('input[type="checkbox"].flat-orange, input[type="radio"].flat-orange').iCheck({
    checkboxClass: 'icheckbox_flat-orange',
    radioClass: 'iradio_flat-orange'
});

//function delete post image
function deletePostImage(id) {
    if (confirm("Are you sure you want to delete this image?")) {
        var data = {
            "id": id
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);

        $.ajax
        ({
            type: 'POST',
            url: base_url + "admin_post/delete_post_image_post",
            data: data,
            success: function (response) {
                location.reload();
            },
            error: function (response) {
                location.reload();
            }
        });
    } else {
        return false;
    }
}

//get subcategories
function get_sub_categories(val) {
    var data = {
        "parent_id": val
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);

    $.ajax({
        type: "POST",
        url: base_url+ 'blog/admin_category/get_sub_categories',
        data: data,
        success: function (response) {
            $("#subcategories").html(response);
        }
    });
}

//Multi Image Previev
window.onload = function () {
    var MultifileUpload = document.getElementById("Multifileupload");
    var MultifileUpload1 = document.getElementById("Multifileupload1");

    if (MultifileUpload) {
        MultifileUpload.onchange = function () {
            if (typeof (FileReader) != "undefined") {
                var MultidvPreview = document.getElementById("MultidvPreview");
                MultidvPreview.innerHTML = "";
                var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
                for (var i = 0; i < MultifileUpload.files.length; i++) {
                    var file = MultifileUpload.files[i];
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var img = document.createElement("IMG");
                        img.height = "100";
                        img.width = "100";
                        img.src = e.target.result;
                        MultidvPreview.appendChild(img);
                        $("#btn_delete_file_image").show();
                    }
                    reader.readAsDataURL(file);
                }
            } else {
                alert("This browser does not support HTML5 FileReader.");
            }
        }
    }

    if (MultifileUpload1) {
        MultifileUpload1.onchange = function () {
            if (typeof (FileReader) != "undefined") {
                var MultidvPreview1 = document.getElementById("MultidvPreview1");
                MultidvPreview1.innerHTML = "";
                var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
                for (var i = 0; i < MultifileUpload1.files.length; i++) {
                    var file = MultifileUpload1.files[i];
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var img = document.createElement("IMG");
                        img.height = "100";
                        img.width = "100";
                        img.src = e.target.result;
                        MultidvPreview1.appendChild(img);
                    }
                    reader.readAsDataURL(file);

                    $("#btn_delete_multi_file_image").show();
                }
            } else {
                alert("This browser does not support HTML5 FileReader.");
            }
        }
    }
};

//reset file input
function reset_file_input() {
    $("#Multifileupload").val('');
    $("#MultidvPreview img").attr('src', null);
    $("#btn_delete_file_image").hide();
}

//reset multi file input
function reset_multi_file_input() {
    $("#Multifileupload1").val('');
    $("#MultidvPreview1 img").remove();
    $("#btn_delete_multi_file_image").hide();
}




