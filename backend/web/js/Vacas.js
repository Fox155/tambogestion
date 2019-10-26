var Vacas = {
    iniciar: function(model){
        var idVaca = model.IdVaca;
        var idLote = model.IdVaca;
        var idSucursal = model.IdVaca;
        new Vue({
            el: "#vacas",
            data: function() {
                return {
                    vaca: model,
                    piols: 'Bien Piola'
                };
            }
        });
    }
}