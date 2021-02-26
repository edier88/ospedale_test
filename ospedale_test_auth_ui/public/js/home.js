
nombre_create.addEventListener("keyup", () =>{validarCampo(nombre_create, /^[a-zA-ZñÑáéíóú]+$/g)})
documento_create.addEventListener("keyup", () =>{validarCampo(documento_create, /^\d{6,12}$/g)})
pass_create.addEventListener("keyup", () =>{validarCampo(pass_create, /^.{8,}$/g)})
genero_create.addEventListener("change", () =>{validarCampo(genero_create, /^(M)$|^(F)$/g)})
fechaNacimiento_create.addEventListener("keyup", () =>{validarCampo(fechaNacimiento_create, /^[1-2][0-9]{3}-[0-9]{2}-[0-9]{2}$/g)})
telefono_create.addEventListener("keyup", () =>{validarCampo(telefono_create, /^\+[0-9]{6,15}$|^[0-9]{6,15}$/g)})
eps_create.addEventListener("change", () =>{validarCampo(eps_create, /^\d{1,3}$/g)})
rol_create.addEventListener("change", () =>{validarCampo(rol_create, /^\d{1,3}$/g)})

function mostrarUser(id){
    axios({
        url: `mostrarUsuarios/${id}`,
        method: 'get',
        responseType: 'json'
    })
    .then((res) => {
        if(res.status==200) {
            return res.data
        }
        console.log(res)
    })
    .catch((error) => {
        console.log('Error de conexión ' + error)
    })
    .then((res) => {
        id_edit.value = res.id
        nombre_edit.value = res.nombre
        documento_edit.value = res.documento
        genero_edit.value = res.genero
        fechaNacimiento_edit.value = res.fecha_nacimiento
        telefono_edit.value = res.telefono
        eps_edit.value = res.eps_id
        rol_edit.value = res.rol_id
        $('#editModal').modal('show')
    })
}

function removeUser(id){
    if (confirm('¿Estas seguro de eliminar este usuario de la base de datos?')){

        axios({
            url: `remove/${id}`,
            method: 'post',
            responseType: 'json'
        })
        .then((res) => {
            if(res.status==200) {
                return res.data
            }
            console.log(res)
        })
        .catch((error) => {
            console.log('Error de conexión ' + error)
        })
        .then((res) => {
            mostrarTabla()
        })
    }
}

buttonCreate.addEventListener("click", () =>{

    if( validarCampo(nombre_create, /^[a-zA-ZñÑáéíóú]+$/g) == false || validarCampo(documento_create, /^\d{6,12}$/g) == false || validarCampo(pass_create, /^.{8,}$/g) == false || validarCampo(genero_create, /^(M)$|^(F)$/g) == false || validarCampo(fechaNacimiento_create, /^[1-2][0-9]{3}-[0-9]{2}-[0-9]{2}$/g) == false || validarCampo(telefono_create, /^\+[0-9]{6,15}$|^[0-9]{6,15}$/g) == false || validarCampo(eps_create, /^\d{1,3}$/g) == false || validarCampo(rol_create, /^\d{1,3}$/g) == false ){
        response_create.innerHTML = 
        `<div class="alert alert-danger" role="alert" class="form-control">
            Diligencie todos los campos de manera correcta porfavor
        </div>`
    } else{

        if (confirm('¿Estas seguro de crear este usuario en la base de datos?')){

            var datos = new FormData();
            datos.append("nombre", nombre_create.value)
            datos.append("documento", documento_create.value)
            datos.append("password", pass_create.value)
            datos.append("genero", genero_create.value)
            datos.append("fecha_nacimiento", fechaNacimiento_create.value)
            datos.append("telefono", telefono_create.value)
            datos.append("eps", eps_create.value)
            datos.append("rol", rol_create.value)
    
            axios({
                url: `create`,
                method: 'post',
                responseType: 'json',
                data: datos
            })
            .then((res) => {
                if(res.status==200) {
                    console.log(res)
                    return res.data
                }
                console.log(res)
            })
            .catch((error) => {
                console.log('Error de conexión ' + error)
                if (error = "Error: Request failed with status code 422"){
                    response_create.innerHTML = 
                    `<div class="alert alert-danger" role="alert" class="form-control">
                        Diligencie todos los campos de manera correcta como se le indica porfavor
                    </div>`
                }
            })
            .then((res) => {
                console.log("creacion")
                console.log(res)
                if(res){
                    response_create.innerHTML =  
                    `<div class="alert alert-success" role="alert" class="form-control">
                        Usuario agregado con éxito
                    </div>`
                    mostrarTabla()
                    $('#createModal').modal('hide')
                }
                
            })
        }
    }
})

buttonUpdate.addEventListener("click", () =>{

    if (confirm('¿Estas seguro de editar este usuario de la base de datos?')){

        var datos = new FormData();
        datos.append("id", id_edit.value)
        datos.append("nombre", nombre_edit.value)
        datos.append("documento", documento_edit.value)
        datos.append("password", pass_edit.value)
        datos.append("genero", genero_edit.value)
        datos.append("fecha_nacimiento", fechaNacimiento_edit.value)
        datos.append("telefono", telefono_edit.value)
        datos.append("eps", eps_edit.value)
        datos.append("rol", rol_edit.value)

        axios({
            url: `update`,
            method: 'post',
            responseType: 'json',
            data: datos
        })
        .then((res) => {
            if(res.status==200) {
                console.log(res)
                return res.data
            }
            console.log(res)
        })
        .catch((error) => {
            console.log('Error de conexión ' + error)
        })
        .then((res) => {
            console.log("actualizacion")
            console.log(res)
            mostrarTabla()
            $('#editModal').modal('hide')
        })
    }
})
    

function mostrarTabla(){

    cadena = ''
    axios({
        url: `mostrarUsuarios`,
        method: 'get',
        responseType: 'json'
    })
    .then((res) => {
        if(res.status==200) {
            return res.data
        }
        console.log(res)
    })
    .catch((error) => {
        console.log('Error de conexión ' + error)
    })
    .then((users) => {
        users.forEach(user => {
            cadena +=
            `<tr class=${user.colorEdad}>
                <th scope="row">${user.id}</th>
                <td>${user.nombre}</td>
                <td>${user.documento}</td>
                <td>${user.genero}</td>
                <td>${user.fecha_nacimiento}</td>
                <td>${user.edad}</td>
                <td>${user.telefono}</td>
                <td>${user.eps.nombre}</td>
                <td>${user.rol.nombre}</td>
                <td>${user.create_at_datetime}</td>
                <td>
                    <div class="row justify-content-center">
                        <div class="col">
                            <button class="btn btn-success btn-sm" type="button" onclick="mostrarUser(${user.id});"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm" type="button" onclick="removeUser(${user.id});"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                </td>
            </tr>`
        });
        bodyTable.innerHTML = cadena
    })   
}

function validarCampo(campo, regex){
    var response = false
    if(!regex.exec(campo.value)){
        campo.setAttribute("class", "form-control is-invalid")
        campo.parentElement.appendChild(document.createElement("div"))
        campo.parentElement.children[2].setAttribute("class","invalid-feedback")
        campo.parentElement.children[2].innerHTML = "No cumple el formato"
        //console.log(`incorrecto: ${campo.value}`)
        response = false
    }else{
        campo.setAttribute("class", "form-control is-valid")
        //console.log(`correcto: ${campo.value}`)
        response = true
    }
    return response
}