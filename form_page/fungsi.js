$(document).ready(function() {
    selesai();
});

function selesai() {
    setTimeout(function() {
        update();
        selesai();
    }, 200);
}

function update() {
    $.getJSON("data.php", function(data) {
        $("table").empty();
        var no = 1;
        $.each(data.result, function() {
            $("table").append(
               "<tr> <td>No</td> <td>User_id</td> <td>Time Check</td></tr>"
                + "<tr><td>" +(no++)+ "</td><td>"
                + this['user_id']+"</td><td>"
                + this['created_timestamp']+"</td></tr>");
        });
    });
}