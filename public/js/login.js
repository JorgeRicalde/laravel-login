const SwalError = Swal.mixin({
    heightAuto: false,
    title: "Error!",
    icon: "error",
    confirmButtonText: "Cerrar",
});

const SwalSuccess = Swal.mixin({
    heightAuto: false,
    icon: "success",
    confirmButtonText: "Cerrar",
});

$.ajaxSetup({
    method: "POST",
    dataType: "json",
    statusCode: {
        401: function () {
            SwalError.fire({
                text: "Iniciar sesion primero",
            });
        },
        403: function () {
            SwalError.fire({
                text: "Esta acción no está autorizada",
            });
        },
        404: function () {
            SwalError.fire({
                text: "Pagina no encontrada",
            });
        },
        422: function ({ responseJSON }) {
            let errors = "";
            Object.entries(responseJSON.errors).forEach(function ([
                key,
                value,
            ]) {
                errors += `<p class='m-0'>${value}</p>`;
            });
            SwalError.fire({
                title: "Los datos proporcionados no son válidos.",
                html: errors,
            });
        },
        500: function () {
            SwalError.fire({
                text: "Error interno del servidor",
            });
        },
    },
});

const TokenManager = {
    exists: () => Boolean(localStorage.getItem("token")),
    setToken: (token) => localStorage.setItem("token", token),
    getToken: () => localStorage.getItem("token"),
    removeToken: () => localStorage.removeItem("token"),
};

const btnSubmitText = $("#btnSubmitText");

if (TokenManager.exists()) {
    $.ajax({
        url: "http://127.0.0.1:8000/api/ping",
        method: "GET",
        cache: false,
        headers: {
            authorization: TokenManager.getToken(),
        },
        success: function ({ access_token, token_type, user }) {
            SwalSuccess.fire({
                title: "Ya inicio sesion previamente",
                text: `Usuario logeado: ${user.name}`,
            });
            TokenManager.setToken(`${token_type} ${access_token}`);
            btnSubmitText.text("Cerrar Sesion");
        },
    });
}

$("#frmLogin").on("submit", function (e) {
    e.preventDefault();
    if (!TokenManager.exists()) {
        const form = new FormData(this);
        $.ajax({
            url: "http://127.0.0.1:8000/api/login",
            data: form,
            cache: false,
            processData: false,
            contentType: false,
            success: function ({ access_token, token_type, user }) {
                SwalSuccess.fire({
                    title: "Inicio de sesion realizado",
                    text: `Usuario logeado: ${user.name}`,
                });
                TokenManager.setToken(`${token_type} ${access_token}`);
                btnSubmitText.text("Cerrar Sesion");
            },
        });
    } else {
        $.ajax({
            url: "http://127.0.0.1:8000/api/logout",
            cache: false,
            headers: {
                authorization: TokenManager.getToken(),
            },
            success: function () {
                SwalSuccess.fire({
                    title: "Se cerro la sesión",
                });
                TokenManager.removeToken();
                btnSubmitText.text("Ingresar");
            },
        });
    }
});
