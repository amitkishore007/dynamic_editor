$(document).ready(function(){

    $('.show-task-form').on('click',function(){
        var task_id = $(this).attr('data-taskId');

        $.ajax({
            type : 'POST',
            url: base_url + "/v1/taskform",
            data: {
                task_id: task_id
            },
            beforeSend: function() {
                $('.task-form').html("<img src='" + base_url + "/loader.gif' class='ajax-loader' />");
            },
            success: function(response) {
                $('.task-form').html('');
                
                if (!response.length) {
                     $('.task-form').html('<h3> Please create new form Param</h3>');
                } else {
                    $('.task-form').html(response);
                }
                
            }

        });

    });

    $('.create-form #process').on('change', function () {
        var select = $(this);
        var process = select.val();

        if (process.length ==0) {
            return false;
        }

         $.ajax({
             type: 'POST',
             url: base_url + "/v1/taskform/getform",
             data: {
                 process : process
             },
             beforeSend: function () {
                select.after("<img src='" + base_url + "/ajax-loader.gif' class='ajax-loader' />");
             },
             success: function (response) {
                 $('.ajax-loader').remove();
                 if (response.length==0) {
                     alert('No task associated with the this process, please create new task');
                 } else {
                     let options = [];
                    response.forEach(function(item){
                        options.push($('<option>', {value:item.id, text:item.name+' ( '+item.action+' ) '}));
                    });
                    $('.create-form #task').html(options);
                 }
             }

         });

    });


    $('#createFormBtn').on('click', function (e) {
        e.preventDefault();
        
        var rules = [];
        var isRequired = false;
        $('.validtion_rules_div input[type="checkbox"]:checked').each(function (i) {
            var checkbox = $(this);
            var valueRequired = Number(checkbox.attr('data-requirevalue'));
            var ruleName = checkbox.attr('data-type');
            // console.log(valueRequired);
            var fieldId = ruleName + '-' + checkbox.val();

            $('#error-'+fieldId).remove();
            if (checkbox.is(":checked")) {
                if (valueRequired) {

                    if ($('#' + fieldId).val().length == 0) {
                        
                        isRequired = true;
                        $('#' + fieldId).after('<span class="text-danger" id="error-' + fieldId + '">Please enter ' + ruleName+' value</span>');
                        alert('Please enter value for validation rule '+ruleName);
                    } else {
                        rules.push({ rule: ruleName,  value: $('#' + fieldId).val() });
                    }
                } else {
                    rules.push({ rule: ruleName});
                }
            } 
            // rules.push(rule);
        });

        console.log(rules);
        if (isRequired) {
            return false;      
        }

        var form_data = {
            process_id      : $('#process').val(),
            order           : $('#w_order').val(),
            name            : $('#field_name').val(),
            type            : $('#fieldType').val(),
            validation_rule : JSON.stringify(rules),
            label           : $('#fieldLabel').val(),
            _token          : $('input[name="_token"]').val()
        };
        
        $.ajax({
            type: 'POST',
            url : base_url + "/v1/taskform/create-field",
            data: form_data,
            beforeSend: function () {
                $('.text-danger').html('');
                 $('.task-form').html("<img src='" + base_url + "/loader.gif' class='ajax-loader' />");
            },
            success: function (response) {
               $('.task-form').html('');
                console.log(response);
                if (response.length == 0) {
                    alert('could not create field, Please try again');
                } else {
                    alert('task field Created !');
                    location.reload();
                }
            },
            error: function(params) {
                console.log(params);
                $('.text-danger').html('');
                var data = params.responseText;
                var responseError = $.parseJSON(data);

                $('.process-error').html(responseError.errors.process_id);
                $('.task-error').html(responseError.errors.task);
                $('.order-error').html(responseError.errors.order);
                $('.name-error').html(responseError.errors.name);
                $('.type-error').html(responseError.errors.type);
                $('.validation_rules-error').html(responseError.errors.validation_rules);
                $('.label-error').html(responseError.errors.label);

            }

        });


    });

    $('.task-list-item').on('click', function () {
        var task_item = $(this);
        var task_id = task_item.attr('data-taskId');
        var title = task_item.attr('data-title');
        var outputLi = $('#dynamic-list-item');
        $.ajax({
            type: 'POST',
            url: base_url +'/v1/taskform/getfields',
            data: {
                task_id: task_id
            },
            beforeSend: function(){
                outputLi.slideUp();
                outputLi.html('');
                task_item.after("<img src='" + base_url + "/ajax-loader.gif' class='ajax-loader' />");
            },
            success: function(response) {
                $('.ajax-loader').remove();
                if (response.length!=0) {
                    task_item.after(outputLi);
                    outputLi.html(response);
                    outputLi.slideDown();
                }
            },
            error : function (jqXHR, exception) {
                console.log(jqXHR);
            }
        });
    }); 



    $('.validtion_rules_div input[type="checkbox"]').on('click', function () {
        var checkbox = $(this);
        var valueRequired = Number(checkbox.attr('data-requirevalue'));
        var ruleName = checkbox.attr('data-type');

        var fieldId = ruleName + '-' + checkbox.val();
        
        var valInput = $('<input>').attr({
            type: 'number',
            id: fieldId,
            name: fieldId,
            placeholder: 'Please enter '+ruleName+' Length' ,
            class :'form-control'
        });
        $('#error-' + fieldId).remove();
        if(checkbox.is(":checked")) {
            if (valueRequired) {
                $('.validtion_rules_div').append(valInput);
            } 
        } else {
                $('#'+fieldId).remove();
        }
    });



    setHeader($('meta[name="csrf-token"]').attr('content'));
});

function ajax_error(jqXHR, exception) {
    var msg = '';
    if (jqXHR.status === 0) {
        msg = 'Not connect.\n Verify Network.';
    } else if (jqXHR.status == 404) {
        msg = 'Requested page not found. [404]';
    } else if (jqXHR.status == 500) {
        msg = 'Internal Server Error [500].';
    } else if (exception === 'parsererror') {
        msg = 'Requested JSON parse failed.';
    } else if (exception === 'timeout') {
        msg = 'Time out error.';
    } else if (exception === 'abort') {
        msg = 'Ajax request aborted.';
    } else {
        msg = 'Uncaught Error.\n' + jqXHR.responseText;
    }
    console.log(jqXHR.responseText);
}

//create a function to set header
function setHeader(data) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': data
        }
    });
}