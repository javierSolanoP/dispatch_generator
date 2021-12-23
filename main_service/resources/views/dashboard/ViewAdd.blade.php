<section>
    <div class="container-back-button">
        <button id="back-button" class="back-button"> < </button>
    </div>
    <div class="addUser">
        <button>
            <img src="../../images/add-user.svg" alt="Icono de añadir">
            <p>Nuevo usuario</p>
        </button>
        <button>
            <img src="../../images/add-services.svg" alt="Icono de añadir">
            <p>Nuevo servicio</p>
        </button>
        <button>
            <img src="../../images/add-permission.svg" alt="Icono de añadir">
            <p>Nuevo permiso</p>
        </button>
    </div>
    <div id="container-add">
        @include('components.AddUser')
    </div>
</section>