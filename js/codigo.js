$(function(){
    $(".reg_producto .btn_mostrar").click(function(e){
        let codprod = $(this).closest(".reg_producto").children(".codprod").text();

        location.href = "listar.php?codprod="+codprod;
    });
});