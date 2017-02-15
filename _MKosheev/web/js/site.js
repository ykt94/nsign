/**
 * Created by MadMax on 06.02.2017.
 */
$(function(){
    $("#btn-select-ingredient").on('click', function(event){
        var selectedItemId = $("#all-ingredients").val();
        var selectedItemText = $("#all-ingredients option:selected").text();
        // добавляем выбранный игнредиент в список
        if (selectedItemId != null) {
            $("#selected-ingredients").append($("<option></option>").val(selectedItemId).html(selectedItemText))
            $("#ingredientIds").val($("#ingredientIds").val() + "," + selectedItemId);
            $("#all-ingredients option:selected").remove();
        }
        event.preventDefault();
    });
})
