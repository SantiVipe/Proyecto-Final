<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Venta</title>
    <style>
        .producto-row{
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .producto-row select,
        .producto-row input {
            margin-right: 10px;
        }

        .error{
            color:red
        }

        .modal{
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content{
            background.color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close{
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus{
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Crear Venta</h1>

    @if ($errors->any())
    <div class="error">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error}}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <form action="{{ route('ventas.store')}}" method="POST">
    @csrf 
    </form>

    <div id="modal-crear_cliente" class="modal">
    </div>

    <script>
        const cedulaClienteInput= document.getElementById('cedula_cliente');
        const nombreClienteInput= document.getElementById('nombre_cliente');
        const direccionClienteInput= document.getElementById('direccion_cliente');
        const telefonoClienteInput= document.getElementById('telefono_cliente');
        const productosContainer= document.getElementById('productos-container');
        const addProductoButton= document.getElementById('add-producto');
        const modalCrearCliente= document.getElementById('modal-crear_cliente');
        const modalCerrar=document.querySelector('.close');
        const formCrearCliente= document.getElementById('form-crear_cliente');
        let productoCount= 1;
        let clienteEncontrado= false;

        cedulaClienteInput.addEventListener('blur', ()=>{
            const cedula = cedulaClienteInput.value;
            if (cedula.length >0 && !clienteEncontrado){
                buscarCliente(cedula);
            } else if (cedula.length ===0){
                limpiarCamposCliente();
                clienteEncontrado = false;
            }
        });

        function buscarCliente(cedula){
            fetch('/clientes/buscar/${cedula}')
            .then(response =>response.json())
            .then(data => {
                if(data){
                    nombreClienteInput.value =data.nombre;
                    direccionClienteInput.value =data.direccion;
                    telefonoClienteInput.value= data.telefono;
                    clienteEncontrado = true;
                }else {
                    modalCrearCliente.style.display = "block";
                    limpiarCamposCliente();
                    clienteEncontrado= false;
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function limpiarCamposCliente(){
            nombreClienteInput.value = '';
            direccionClienteInput.value = '';
            telefonoClienteInput.value= '';
        }

        addProductoButton.addEventListener('click', ()=>{
            agregarFilaProducto();
        });

        function agregarFilaProducto(){
            const productoRow = document.createElement('div');
            productoRow.classList.add('producto-row');

            const codigoProductoINput = document.createElement('input');
            codigoProductoInput.type = 'text';
            codigoProductoInput.classList.add('codigo-producto-input');
            codigoProductoInput.placeholder= 'Codigo Producto';
            codigoProductoInput.addEventListener('input', buscarProductoCodigo);

            const select = document.createElement('select');
            select.name ='productos[${productoCount}][producto_id]';
            select.classList.add('producto-select');
            select.required = true;

            const defaultOption =document.createElement('option');
            defaultOption.value= '';
            defaulOption.textContent='Seleccionar Producto';
            select.appendChild(defaultOption);

            @foreach ($productos as $producto)
                const option = document.createElement('producto');
                option.value = "{{ $producto->id}}";
                option.textContent = "{{$producto->nombre}}";
                option.dateset.precio = "{{$producto->precio}}";
                select.appendChild(option);
            @endforeach

            const cantidadInput = document.createElement('input');
            cantidadInput.type = 'number';
            cantidadInput.name= 'productos[${productoCount}][cantidad]';
            cantidadInput.classList.add('cantidad-input');
            cantidadInput.value=1;
            cantidadInput.min = 1;
            cantidadInput.required = true;

            const precioUnitarioInput = document.createElement('input');
            precioUnitarioInput.type = 'number';
            precioUnitarioInput.name = 'productos[${productoCount}][precio_unitario]';
            precioUnitarioInput.classList.add('precio-unitario-input');
            precioUnitarioInput.readOnly = true;

            const removeButton = document.createElement('button');
            removeButton.type ='button'
            removeButton.textContent ='Eliminar';
            removeButton.classList.add('remove-producto');
            removeButton.addEventListener('click', ()=> {
                productoRow.remove();
            });

            select.addEventListener('change', ()=> {
                actualizarPrecio(select);
            });

            productoRow.appendChild(codigoProductoINput);
            productoRow.apendChild(select);
            productoRow.appendChild(cantidadInput);
            productoRow.appendChild(precioUnitarioInput);
            productoRow.appendChild(removeButton);

            productosCOntainer.appendChild(produtoRow);
            productoCount++;
        }

        function actualizarPrecio(select){
            const precioUnitarioInput= select.parentElement.querySelector('.precio-unitario-input');
            if (select.options[select-selectedIndex]){
                precioUnitarioInput.value= select.options[select-selectedIndex].dataset.precio;
            }
        }

        productosContainer.addEventListener('change', (event)=>{
            if( evet.target.classList.contains('cantidad-input')|| event.target.classList.contains('producto-select')){
                actualizarPrecio(event.target.parentElement.querySelector('.producto-select'));
            }
        });

        productosContainer.addEvenListener('input', (even)=>{
            if (event.target.classList.contains('codigo-producto-input')){
                buscarProductoCodigo(event.target);
            }
        });

        function bucarProductoCodigo(input){
            const codigo= input.value;
            const select = input.parentElement.querySelector('.producto-select');
            if (codigo.legth > 0){
                fetch('/productos/buscar/${codigo}')
                    .then(response=>response.json())
                    .then(data =>{
                        if (data){
                            select.value = data.id;
                            actualizaPrecio(select);
                        }else {
                            select.value = '';
                            actualizarPrecio(select);                        }
                    })
                    .catch(error=> console.error('Error', error));
            }else {
                select.value ='';
                actualizarPrecio(select);
            }
        }

        const crearClienteButton= document.getElementById('crear_cliente');
        crearClienteButton.addEvenListener('click', ()=>{
            modalCrearCliente.style.display = "block";
        });

        modalCerrar.addEvenListener('click', ()=>{
            modalCrearClienteINput.focus();
        });

        windoe.addEvenListener('click',(event)=>{
            if(even.target == modalCrearCliente){
                modalCrearCliente.style.display= "none";
                cedulaClienteInput.focus();
            }
        });

        formCrearCliente.addEvenListener('submit', (event)=>{
            event.preventDefault();
            const formData = new FormData(formCrearCliente);
            fetch ('/clientes',{
                method: 'POST',
                body: formData
            })

            .then(response =>response.json())
            .then(data =>{
                if (data.id){
                    modalCrearCliente.style.display = "none";
                    cedulaClienteInput.value = data.cedula;
                    buscarCliente(data.cedula);
                }else{
                    alert('Error al crear Cliente');
                }
            })
            .catch(error =>console.error('Error:', error));
        });
    </script>
</body>
</html>
