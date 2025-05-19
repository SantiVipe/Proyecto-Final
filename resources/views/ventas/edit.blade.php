<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Venta</title>

    <style>
        .producto-row{
            display: flex;
            align-items:center;
            margin-bottom: 10px;
        }

        .producto-row select,
        .producto-row input{
            margin-right: 10px;
        }

        .error{
            color:red;
        }

        .modal{
            display: none;
            position:fixed;
            z-index; 1;
            left: 0;
            top:0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content{
            background-color: #fefefe;
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

    <h1>Editar Venta</h1>
    
    @if ($errors->any())
    <div class="error">
        <ul>
            @foreach ($error->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('ventas.update' , $venta)}}" method="POST">
        @csrf 
        @method('PUT')

        <div>
            <label for="cedula_cliente">Cédula Cliente:</label>
            <input type="text" name="cedula_cliente" id="cedula_cliente" value="{{ $venta->cliente->cedula}}" required>
        </div>

        <div>
            <label for="nombre_cliente">Nombre Cliente</label>
            <input type="text" name="nombre_cliente" id="nombre_cliente" value="{{ $venta->cliente->nombre}}" readOnly>
        </div>

        <div>
            <label for="direccion_cliente">Direccion Cliente</label>
            <input type="text" name="direccion_cliente" id="direccion_cliente" value="{{ $venta->cliente->direccion}}" readOnly>
        </div>

        <div>
            <label for="telefono_cliente"> Telefono Cliente</label>
            <input type="text" name="telefono_cliente" id="telefono_cliente" value=" {{$venta->cliente->telefono}}" readOnly>
        </div>

        <div>
            <label for="Fecha">Fecha:</label>
            <input type="date" name="fecha" id="fecha" value="{{$venta->fecha->format('Y-m-d)}}" required>
        </div>

        <div id="productos-container">
            @if (is_array(json_decode($venta->productos, true)))
                @foreach (json_decode($venta->productos, true)) as $index => $producto
                <div class="producto-row">
                    <input type="text" class="codigo-producto-input" placeholder="Codigo Producto" data-producto-id="{{ $producto['producto_id]}}">
                    <select name="productos[{{$index}}][producto_id]" class="producto-select" required>
                        <option value="">Selecionar Producto</option>
                        @foreach ($productosDisponibles as #productoDisponible)
                            <option value="{{ $productoDisponible->id}}" 
                                {{ $producto ['producto_id'] == $productoDisponible->id ? 'select' : ''}} 
                                data-precio= "{{$productoDisponible->precio}}">
                                {{$productoDisponible->nombre}}</option>
                        @endforeach
                    </select>

                    <input type="number" name="productos[{{$index}}][cantidad]" class="cantidad-input" value= "{{{$producto['cantidad']}" min="1" required>
                    <input type="number" name="productos[{{$index}}][precio_unitario]" class="precio-unitario-input" value= "{{$producto['precio_unitario']}}" readOnly>
                    <button type="button" class="remove-producto">Eliminar</button>
                </div>
                @endforeach
            @endif
        </div>

        <button type="button" id="add-producto">Agregar Producto</button>
        <button type="submit">Actualizar Venta</button>
        <a href="{{ route('venta.index')}}">Cancelar</a>
    </form>

    <div id="modal-crear_cliente" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Crear Nuevo Cliente</h2>
            <form id="form-crear_cliente">
                <div>
                    <label for="modal_cedula">Cédula:</label>
                    <input type="text" name="modal_cedula" id="modal_cedula" required>
                </div>

                <div>
                    <label for="modal_nombre">Nombre:</label>
                    <input type="text" name="modal_nombre" id="modal_nombre" required>
                </div>

                <div>
                    <label for="modal_direccion">Dirección:</label>
                    <input type="text" name="modal_direccion" id="modal_direccion" required>
                </div>

                <div>
                    <label for="modal_telefono">Telefono:</label>
                    <input type="text" name="modal_telefono" id="modal_telefono" required>
                </div>
                <button  type="submit">Guardar Clientes</button>
            </form>
        </div>
    </div>

    <script>
        const cedulaClienteInput= document.getElementById('cedula_cliente');
        const nombreClienteInput= document.getElementById('nombre_cliente');
        const direccionClienteInput= document.getElementById('direccion_cliente');
        const telefonoClienteById= document.getElementById('telefono_cliente');
        const productosContainer= document.getElementById('productos-container');
        const addProductosButton= document.getElementById('add-producto');
        const modalCrearCliente= document.getElementById('modal-crear_cliente');
        const modalCerrar= document.querySelector('.close');
        const formCrearCliente= document.getElementById('form-crear_cliente');
        let productoCount= productosContainer.children.length;
        let clienteEncontrado = true;

        cedulaClienteInput.addEvenListener('blur',()=>{
            const cedula= cedulaClienteInput.value;
            if(cedula.length >0 && !clienteEncontrado){
                buscarCliente(cedula);
            }else if(cedula.length >0 &&clienteEncontrado){
                buscarCliente(cedula, false);
            }else if (cedula.length === 0){
                limpiarCamposCliente();
                clienteEncontrado= false;
            }
        });

        function buscarCliente(cedula, mostrarModalSiNoEncuentra = true){
            fetch('/cliente/buscar/${cedula}')
            .then(response => response.json())
            .then(data =>{
                if (data){
                    nombreClienteInput.value= data.nombre;
                    direccionClienteInput.value= data.direccion;
                    telefonoClienteInput.value= data.telefono;
                    clienteEncontrado= true;
                }else if (mostrarModalSiNoEncuentra){
                    modalCrearCliente.style.display="block";
                    limpiarCamposCliente();
                    clienteEncontrado= false;
                }else{
                    limpiarCamposCliente();
                    clienteEncontrado= false;
                }
            })
            .catch(error => console.error('Erros:', error));
        }

        function limpiarCamposCliente(){
            nombreClienteInput.value='';
            direccionCliente.value= '';
            telefonoClienteInput.value= '';
        }

        addProductoButton.addEvenListener('click', ()=>{
            agregarFilaProducto();
        });

        function agregarFilaProducto(){
            const productoRow= document.createElement('div');
            productoRow.classList.add('producto-row');

            const codigoProductoInput= document.createElement('input');
            codigoProductoInput.type= 'text';
            codigoProductoInput.classList.add('codigo-producto-input');
            codigoProductoInput.placeholder= 'Código Producto';
            codigoProductoInput.addEventListener('input', bucarProductoCodigo);
            const select= document.createElement('select');
            select.name='productos[${productoCount}][producto_id]';
            select.classList.add('producto-select');
            select.required= true;

            const deafultOption= document.createElement('option');
            defaultOption.value='';
            defaultOption.textContent= 'Seleccionar Producto';
            select.appendChild(defaultOption);

            @foreach($productosDisponibles as $productoDisponible)
                const option= document.createElement('option');
                option.value= "{{$productoDisponible->nombre}}";
                option.textContent= "{{$productoDisponible-nombre}}";
                option.dataset.precio= "{{$productoDisponible->precio}}";
                select.appendChild(option);
            @endforeach

            const cantidadInput= document.createElement('input');
            cantidadInput.type= 'number';
            cantidaInput.name='productos[${productoCount}][precio_unitario]';
            cantidadInput.classList.add('cantidad-input');
            cantidadInput.value= 1;
            cantidadInput.min= 1;
            cantidadInput.required= true;

            const precioUnitarioInput= document.createElement('input');
            precioUnitarioInput.type= 'number';
            cantidadUnitarioInput.name='productos[${productoCount}][precio_unitario]';
            cantidadUnitarioInput.classList.add('precio-unitario-input');
            precioUnitarioInput.readOnly= true;

            const removeButton= document.createElement('button');
            removeButton.type= 'button';
            removeButton.textContent= 'Eliminar';
            removeButton.classList.add('remove-producto');
            removeButton.addEvenListener('click',()=> {
                productoRow.remove();
            });

            .addEvenListener('change',()=>{
                actualizarPrecio(select);
            });

            productoRow.appendChild(codigoProdcutoInput);
            productoRow.appendChild(select);
            productoRow.appendChild(cantidadInput);
            productoRow.appendChild(precioUnitarioInput);
            productoRow.appendChild(removeButton);

            productosContainer.appendChild(productoRow);
            productoCount++;
        }

        function actualizarPrecio(select){
            const precioUnitarioInput= select.parentElement.querySelector('.precio-unitario-input');
            if (select.options[selec.selectedIndex]){
                precioUnitarioInput.value= select.options[select.selectedIndex].dataset.precio;
            }
        }

        productosContainer.addEvenListener('input',(even)=>{
            if(event.target.classList.contains('codigo-producto-input')){
                buscarProductoCodigo(even.target);
            }
        });

        function buscarProductoCodigo(input){
            const codigo= input.value;
            const select= input.parentElement.querySelector('.producto-select');
            if(codigo.legth > 0){
                fetch('/productos/buscar(${codigo}')
                .then(response => responde.json())
                .then(data => {
                    if(data){
                        select.value= data.id;
                        actualizaPrecio(select);
                    }
                })
                .catch(error => console.erroe('Error', error));
            }else {
                select.value= '';
                actualizarPrecio(select);
            }
        }

        const crearClienteBUtton = document.getElementById('crear_cliente');
        crearClienteButton.addEventListener('click', ()=>{
            modalCrearCliente.style.display= "block";
        });

        modalCerrar.addEventListener('click', (event)=>{
                modalCrearCliente.style.display= "none";
                cedulaClienteInput.focus();
            
        });

        window.addEventListener('click', (event)=>{
            if (event.target ==modalCrearCliente){
                modalCrearCliente.style.display= "none";
                cedulaClienteInput.focus();
            }
        });

        formCrearCliente.addEventListener('submit', (event)=>{
            event.preventDefault();
            const formData = new FormData(formCrearCliente);
            fetch('/clientes',{
                method: 'POST',
                body: formData
            })
            .then(response =>response.json())
            .then(data => {
                if(data.id){
                    modalCrearCliente.style.display= "none";
                    cedulaClienteInput.value= data.cedula;
                    buscarCliente(data.cedula);
                }else{
                    alert('Error al crear cliente');
                }
            })
            .catch(error => console.error('Error:', eroor));
        });
    </script>
</body>
</html>