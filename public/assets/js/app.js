$(document).ready(function() {
    // Even for form submit onClick
    $(document).on('submit', '#myForm', function(e){
        errorReset();
        var validation = validateInputs();
        e.preventDefault();
        if (validation) {
            var formData = $(this).serialize();
            $.ajax ({
                url : 'ajax/getFinanceData.php',
                type : 'POST',
                async : false,
                dataType:'html',
                data : formData,
                success : function(result) {
                    // Clear results container
                    $('#myContainer').html('');

                    // Append results to container
                    $('#myContainer').append(result);

                } // ajax function success
            }); // ajax call
        }
    }); // event listener function
});

// initialize chart function
// function initChart (chartId, label, data1, data2 ) {
//
//     const data = {
//         labels: label,
//         datasets: [{
//             label: 'Open Prices',
//             data: data1,
//             backgroundColor: '#80c8bb',
//             order: 1,
//             stack: 'stack0'
//         },
//             {
//                 label: 'Close Prices',
//                 data: data2,
//                 backgroundColor: 'rgb(241,151,151)',
//                 order: 2,
//                 stack: 'stack1'
//             }
//         ]
//     };
//
//     const config = {
//         type: 'bar',
//         data: data,
//         options: {
//             title: {
//                 display: true,
//                 position: 'top',
//                 align: 'center',
//                 fontSize: '25',
//                 fontColor: '#000000',
//                 text: 'Open and Close Values Chart'
//             },
//             plugins: {
//                 tooltip: {
//                     mode: 'index'
//                 }
//             },
//             scales: {
//                 x: {
//                     stacked: true
//                 },
//                 y: {
//                     stacked: true
//                 }
//             }
//         },
//     };
//
//     const reportOutput = new Chart(
//         $('#' + chartId),
//         config
//     );
// }

function validateInputs () {
    var mySymbol = $('#compSymbol').val();
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();
    var email = $('#myEmail').val();
    var check = true;
    if (mySymbol =='' || mySymbol ==0) {
        $('#compSymbol').addClass('inputError');
        $('#compSymbol').next('.invalid-feedback').show();
        check = false;
    }
    if (startDate =='' || startDate ==0) {
        $('#startDate').addClass('inputError');
        $('#startDate').next('.invalid-feedback').show();
        check = false;
    }
    if (endDate =='' || endDate ==0) {
        $('#endDate').addClass('inputError');
        $('#endDate').next('.invalid-feedback').show();

        check = false;
    }
    if (email =='' || email ==0) {
        $('#myEmail').addClass('inputError');
        $('#myEmail').next('.invalid-feedback').show();
        check = false;
    }
    return check;
}

function errorReset() {
    $('#compSymbol').removeClass('inputError');
    $('#startDate').removeClass('inputError');
    $('#endDate').removeClass('inputError');
    $('#myEmail').removeClass('inputError');
    $('.invalid-feedback').hide();
    $('#myError').hide();
}