$(document).ready(function () {
    $('#selectAll').click(function () {
        let state = $('#selectAll').prop("checked");
        let checkbox = $('.selectRow');
        checkbox.prop("checked", state);
        // if(checkbox.length) toggleDelBtn(state, checkbox.length);
    });
    
    $('.selectRow').click(function () {
        let checkedRow = $('.selectRow:checked');
        isSellectAll = checkedRow.length === $('.selectRow').length;
        selectAll = $('#selectAll');
        if(checkedRow.length){

        }else {}
        if((isSellectAll && !selectAll.prop("checked"))||(!isSellectAll && selectAll.prop("checked"))){
            selectAll.prop("checked", isSellectAll);
        }
    });
});