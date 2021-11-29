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

    }
}