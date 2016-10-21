/**
 * Created by servandomac on 3/12/15.
 */
$(function(){
    $("#date").datepicker({
        showOn: "button",
        dateFormat: "yy-mm-dd",
        buttonImage: imgCalendar,
        buttonImageOnly: true,
        buttonText: "Select date"
    });

    $('#build-form').bootstrapValidator({
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            business: {
                validators: {
                    notEmpty: {
                        message: 'El campo "negocio" es obligatorio.'
                    }
                }
            },
            metric_goal: {
                validators: {
                    notEmpty: {
                        message: 'El campo "métrico" es obligatorio.'
                    },
                    regexp: {
                        regexp: /^\d+(?:\.\d+)?$/,
                        message: 'El campo "métrico" debe ser entero o decimal.'
                    }
                }
            },
            actual: {
                validators: {
                    regexp: {
                        regexp: /^\d+(?:\.\d+)?$/,
                        message: 'El campo "actual" debe ser entero o decimal.'
                    }
                }
            },
            ytd: {
                validators: {
                    regexp: {
                        regexp: /^\d+(?:\.\d+)?$/,
                        message: 'El campo "ytd" debe ser entero o decimal.'
                    }
                }
            },
            members: {
                validators: {
                    notEmpty: {
                        message: 'El campo "miembros" es obligatorio.'
                    }
                }
            },
            inversion: {
                selector: '.inversionField',
                validators: {
                    regexp: {
                        regexp: /^\d+(?:\.\d+)?$/,
                        message: 'El campo debe ser entero o decimal.'
                    }
                }
            }
        }
    });

});