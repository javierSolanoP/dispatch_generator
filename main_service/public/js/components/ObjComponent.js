export const component = {

    // Metodo para mostrar el componente: 
    view: function (button, name)
    {

        let elementButton = document.querySelector('#' + button),
            elementComponent = document.querySelector('.' + name);

        elementButton.addEventListener('click', function (event) {

            event.preventDefault();

            elementComponent.innerHTML = `<h1>Hello world!`
        });

    },
    
    // Metodo para redireccionar vistas dentro de un componente: 
    redirect: function (button, component, view) {
        
        // Seleccionamos los elementos: 
        let elementButton = document.querySelector('#' + button),
            // Componente padre:  
            elementComponent = document.querySelector('#' + component),
            // Vista a redireccionar: 
            elementView = document.querySelector('#' + view);

        // Escuchamos el evento 'click': 
        elementButton.addEventListener('click', function (event) {

            event.preventDefault();

            // Deshabilitamos la visibilidad de la vista actual: 
            elementComponent.style.display = 'none';

            // Activamos la visibilidad de la vista requerida: 
            elementView.style.display = 'flex';
            
        });
    }
}