$(document).ready(function() {
    $(function() {
        if( $('#userLogDatePicker').length ){     
            $('#userLogDatePicker').datetimepicker({      
                viewMode : 'months',
                format : 'MMM-YYYY',
                toolbarPlacement: "top"   
            }).datetimepicker("setDate", new Date());

            $('#userLogDatePicker').data("DateTimePicker").date(moment().subtract(1, 'days'));
        }
    });
});