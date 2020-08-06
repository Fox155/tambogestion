var Vacas = {
    iniciar: function(model){
        // var idVaca = model.IdVaca;
        // var idLote = model.IdVaca;
        // var idSucursal = model.IdVaca;
        new Vue({
            el: "#vacas",
            vuetify: new Vuetify(),
            data: function() {
                return {
                    piolavacas: model,
                    piols: 'Bien Piola'
                };
            }
        });
    }
}