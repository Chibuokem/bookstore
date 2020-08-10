const errorDisplay = (message) => swal(message, 'Failed', 'error');

const successDisplay = (message) => swal(message, 'successful', 'success');

const successNoty = (message) => swal(message, 'successful', 'success');

const failJson = ({ responseJSON: response }) => {
    errorDisplay(`${response.error.message}`)
};

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ajaxStart(function() {
    $('.loading_modal').show();
}).ajaxStop(function() {
    $('.loading_modal').hide();
});

function copyFunction(elementId) {
    /* Get the text field */
    var copyText = document.getElementById(elementId);
    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /*For mobile devices*/
    /* Copy the text inside the text field */
    document.execCommand("copy");
    /* Alert the copied text */
    alert("Copied : " + copyText.value);
}

$(document).ready(function() {
    $("#quantity").keyup(function() {
        var quantity = $("#quantity").val();
        var price = $("#type").find(':selected').attr('data-amount');
        if (price == "" || quantity == "") {
            return;
        }
        var total = (quantity * price);
        $("#total").text("₦" + total);
    });

    $("#quantity").change(function() {
        var quantity = $("#quantity").val();
        var price = $("#type").find(':selected').attr('data-amount');
        if (price == "" || quantity == "") {
            return;
        }
        var total = (quantity * price);
        $("#total").text("₦" + total);
    });

    $("#type").change(function() {
        var quantity = $("#quantity").val();
        var price = $("#type").find(':selected').attr('data-amount');
        if (price == "" || quantity == "") {
            return;
        }
        var total = (quantity * price);
        $("#total").text("₦" + total);
    });
});