$(function(){
    $(".exam_chk").click(function(){
        var _key=$(this).attr("class").split(" ")[1].split("_")[1];
        $(".chk_"+_key).prop("checked",false);
        $(this).prop("checked",true);
        return true;
    });
});