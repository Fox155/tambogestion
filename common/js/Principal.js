var Main = {
    opciones: {
        ajax: {
            trackMethods: ['GET', 'POST']
        },
        tooltip: {
            container: 'body',
            title: function () {
                return $(this).data('mensaje');
            }
        }
    },
    selectores: {
        tooltip: '[data-mensaje]', // Mensaje al pasar el cursor
        selectOnFocus: '[data-focus-select]', // Seleccionar el texto al hacer focus
        modal: '[data-modal]', // Request para pedir cargar una ventan modal
        ajax: '[data-ajax]' // Request a la url indicada
    },
    iniciar: function(){
        var _this = Main;
  
        // Selecciono como activa la pestaña actual
        $('.nav-tabs').find('a').each(function () {
            if ($(this).attr('href') != '/' && $(this).attr('href').indexOf(window.location.pathname) == 0)
                $(this).closest('li').addClass('active');
        });

        _this.iniciarAjax();
        _this.iniciarEventos();
    },
    iniciarAjax: function () {
        var _this = Main;
        $('.tooltip').remove();
  
        $(_this.selectores.tooltip).tooltip(_this.opciones.tooltip);
    },
    iniciarEventos: function () {
        var _this = Main;
  
        $('body').on('pjax:complete', function () {
            _this.initAjax();
        });
  
        $('body').on('click', _this.selectores.selectOnFocus, function (event) {
            $(event.target).select();
        });
  
        $('body').on('click', _this.selectores.modal, function () {
            _this.modal($(this).data('modal'));
        });
  
        // Hacer request con ajax en los elementos con data-ajax=url. Evita recarga y muestra mensaje de éxito si hay data-success
        $('body').on('click', _this.selectores.ajax, function (e) {
            _this.ajax(this);
        });
    },
    _obtenerOpcionesMask: function (inputs) {
        var maskOptions = {};
  
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].inputmask)
            {
                maskOptions[i] = inputs[i].inputmask.userOptions;
            }
        }
  
        return maskOptions;
    },
    _restaurarMask: function (inputs, maskOptions) {
        for (var i = 0; i < inputs.length; i++) {
            if (maskOptions[i])
                $(inputs[i]).inputmask(maskOptions[i]);
        }
    },
    obtenerFormData: function (form) {
        var $form = $(form);
        var inputs = $form.find('input');
  
        var maskOptions = Main._obtenerOpcionesMask(inputs);
  
        inputs.inputmask('remove');
  
        var datos = new FormData(form);
  
        Main._restaurarMask(inputs, maskOptions);
  
        return datos;
    },
    modalCerrar: function () {
        $('.modal').remove();
        $('.modal-backdrop').remove();
    },
    modal: function (url) {
        var _this = Main;
  
        // Solo puedo abrir hasta dos modales
        if ($('.modal').length > 1)
            return;
  
        var html = '<div class="modal fade"></div>';
  
        $(html).modal({
            backdrop: 'static',
            keyboard: false})
                .on('hidden.bs.modal', function () {
                    $(this).remove();
                })
                .load(url, function () {
                    var $modal = $(this);
                    var $form = $(this).find('form');
  
                    setTimeout(function () {
                        $('.modal').trigger('shown.bs.modal');
  
                        // Obtengo el primer input no oculto
                        var $primerInput = $form.find('input:not([type=hidden]),select').filter(':first');
  
                        // Hago focus si es type=text o select
                        if ($primerInput.attr('type') == 'text' || $primerInput.is('select'))
                            $primerInput.focus();
  
                        _this.iniciarAjax();
  
                    }, 500);
                    $modal.on('beforeSubmit', 'form', function (e) {
                        _this.submitModal(this);
                        e.preventDefault();
                        e.stopPropagation();
                        e.stopImmediatePropagation();
                        return false;
                    });
                });
    },
    submitModal: function (form) {
        var $form = $(form);
  
        // Se usa FormData porque permite también la subida de archivos
        var datos = Main.obtenerFormData(form);
  
        //Desactivo el botón de submit, para que el usuario no realice clicks 
        //repetidos hasta que se reciba la respuesta del servidor.
        $form.closest('.modal-content').find('[data-dismiss=modal]').attr('disabled', true);
        $form.find(':submit').attr('disabled', true);
  
        //Se realiza el request con los datos por POST        
        $.ajax({
            url: $form.attr("action"),
            data: datos,
            type: 'POST',
            contentType: false,
            processData: false, })
                .done(function (data) {
                    if (data.error)
                    {
                        var evento = jQuery.Event("error.modalform");
                        $('.modal').trigger(evento, [data]);
  
                        if (!evento.isDefaultPrevented())
                        {
                            mensaje = data.error;
                            tipo = 'warning';
                            //Agregando mensaje de error al diálogo modal
                            var html = '<div id="mensaje-modal" class="alert alert-' + tipo + ' alert-dismissable">'
                                    + '<i class="fa fa-ban"></i> '
                                    + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
                                    + '<b class="texto" >' + mensaje + '</b>'
                                    + '</div>';
                            $('#errores-modal').html(html);
                        }
  
                        //Se activa nuevamente el botón
                        $form.closest('.modal-content').find('[data-dismiss=modal]').attr('disabled', false);
                        $form.find(':submit').attr('disabled', false);
                    }
                    else
                    {
                        var evento = jQuery.Event("success.modalform");
                        $('.modal').trigger(evento, [data]);
  
                        if (!evento.isDefaultPrevented())
                        {
                            if ($form.closest(".modal-dialog").data('no-reload') === undefined)
                                location.reload();
                            else
                                $('.modal').modal('hide');
                        }
                        else
                        {
                            //Se activa nuevamente el botón
                            $form.closest('.modal-content').find('[data-dismiss=modal]').attr('disabled', false);
                            $form.find(':submit').attr('disabled', false);
                        }
                    }
                })
                .fail(function (data) {
                    if (data.status !== 302)
                    {
                        var evento = jQuery.Event("error.modalform");
                        $('.modal').trigger(evento);
  
                        if (!evento.isDefaultPrevented())
                        {
                            var tipo = 'danger';
                            var mensaje = 'Error en la comunicación con el servidor. Contacte con el administrador.';
                            //Agregando mensaje de error al diálogo modal
                            var html = '<div id="mensaje-modal" class="alert alert-' + tipo + ' alert-dismissable">'
                                    + '<i class="fa fa-ban"></i> '
                                    + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
                                    + '<b class="texto" >' + mensaje + '</b>'
                                    + '</div>';
                            $('#errores-modal').html(html);
                            //Se activa nuevamente el botón
                            $form.closest('.modal-content').find('[data-dismiss=modal]').attr('disabled', false);
                            $form.find(':submit').attr('disabled', false);
                        }
                    }
                });
    },
    // Hacer request con ajax en los elementos con data-ajax=url. Evita recarga y muestra mensaje de éxito si hay data-success
    ajax: function (elemento) {
        var url = $(elemento).data('ajax');
        var success = $(elemento).data('success');
  
        $.get(url)
                .done(function (data) {
                    if (data.error)
                    {
                        var evento = jQuery.Event("error.ajax");
                        $(elemento).trigger(evento, [data]);
  
                        if (!evento.isDefaultPrevented())
                        {
                            var tipo = 'danger';
                            var mensaje = data.error;
                            var icono = 'ban';
                            //Agregando mensaje de error al diálogo modal
                            var html = '<div id="mensaje-modal" class="alert alert-' + tipo + ' alert-dismissable">'
                                    + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
                                    + '<i class="fa fa-' + icono + '"></i> '
                                    + '<b class="texto" >' + mensaje + '</b>'
                                    + '</div>';
                            $('#errores').html(html);
                        }
                    }
                    else
                    {
                        if (success)
                        {
                            var tipo = 'success';
                            var mensaje = success;
                            var icono = 'check';
                            //Agregando mensaje de error al diálogo modal
                            var html = '<div id="mensaje-modal" class="alert alert-' + tipo + ' alert-dismissable">'
                                    + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
                                    + '<i class="fa fa-' + icono + '"></i> '
                                    + '<b class="texto" >' + mensaje + '</b>'
                                    + '</div>';
                            $('#errores').html(html);
                        }
                        else
                        {
                            var evento = jQuery.Event("success.ajax");
                            $(elemento).trigger(evento, [data]);
  
                            if (!evento.isDefaultPrevented())
                            {
                                if ($.support.pjax)
                                {
                                    window.location.hash = '';
                                    $.pjax.reload('#pjax-container');
                                }
                                else
                                    location.reload();
                            }
                        }
                    }
                })
                .fail(function () {
                    var tipo = 'danger';
                    var mensaje = 'Error en la comunicación con el servidor. Contacte con el administrador.';
                    var icono = 'ban';
                    //Agregando mensaje de error al diálogo modal
                    var html = '<div id="mensaje-modal" class="alert alert-' + tipo + ' alert-dismissable">'
                            + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'
                            + '<i class="fa fa-' + icono + '"></i> '
                            + '<b class="texto" >' + mensaje + '</b>'
                            + '</div>';
                    $('#errores').html(html);
                });
    },
    topFuntion: function(){
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    },
}