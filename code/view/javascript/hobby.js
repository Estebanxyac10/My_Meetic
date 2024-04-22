$(document).ready(() => {
    $.ajax({
        type: "get",
        url: "./code/controller/hobby.php",
        dataType: "json",
        success: function (response) {
            response.forEach(hobby => {
                $("#register__checkbox").append(`<input class="hobby__register" type="checkbox" name="hobbies[]" value="${hobby.id_hobby}">${hobby.name_hobby}<br>`);
            });
        }
    });
});