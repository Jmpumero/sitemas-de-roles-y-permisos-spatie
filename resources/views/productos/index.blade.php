@extends('layouts.app')

@section('content')
<head>


    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

    <title>DataTables de productos</title>
</head>
<div class="container">
<!-- tabla de productos-->
    <table id="table_products" class="table">
        <button id="nuevo_producto" class=" btn-nuevo btn-primary " style="float-right">Nuevo</button>
        <thead>
            <tr>
                <th width="10px">ID</th>
                <th width="350px">Nombre</th>
                <th width="200px">Precio</th>
                <th width="130px">Acción</th>
            </tr>
        </thead>
    </table>
</div>


<div id="formModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
     <div class="modal-content">
      <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal">&times;</button>
             <h4 class="modal-title">Añadir un nuevo Usuario</h4>
           </div>
           <div class="modal-body">
            <span id="form_result"></span>

            <form method="post" id="sample_form" class="form-horizontal">

             <div class="form-group">
               <label class="control-label col-md-4" >Nombre: </label>
               <div class="col-md-8">
                <input type="text" name="nombre" id="nombre" class="form-control" />
               </div>
              </div>
              <div class="form-group">
               <label class="control-label col-md-4">Precio: </label>
               <div class="col-md-8">
                <input type="text" name="precio" id="precio" class="form-control" />
               </div>


              </div>
                   <br />
                   <div class="form-group" >
                    <input type="hidden" name="action" id="action" value="Añadir" />
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="submit" name="action_button" id="action_button" class="btn btn-primary" value="Añadir" />
                   </div>
            </form>



           </div>
        </div>
       </div>
   </div>






   <!--Jquery-->


















<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!--datatable jquery-->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<!--Boostrap-->
<!-- JS, Popper.js, and jQuery -->

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            //console.log('X-CSRF-TOKEN');
        }
    });

    $(document).ready(function() {
       var tabla_productos= $('#table_products').DataTable({
            "serverSide": true,
            "processing": true,
            "ajax": "{{ route('productos.index') }}",
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'nombre'},
                {data: 'precio'},

                {data: 'action', name: 'btn', orderable: false, searchable: false},
            ],
            "language": {
                "info": "_TOTAL_ registros",
                "search": "Buscar",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior",
                },
                "lengthMenu": 'Mostrar <select >'+
                            '<option value="10">10</option>'+
                            '<option value="30">30</option>'+
                            '<option value="-1">Todos</option>'+
                            '</select> registros',
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "emptyTable": "No hay datos",
                "zeroRecords": "No hay coincidencias",
                "infoEmpty": "",
                "infoFiltered": ""
            }
        });



    $('body').on('click', '#btn-eliminar', function () {

        var producto_id = $(this).data("id");
        var rol=$(this).data("rol");
        //var token = $("meta[name='csrf-token']").attr("content");
        //confirm("Are You sure want to delete !");

        console.log(producto_id);
        //console.log("productos/eliminar/"+rol+"/"+producto_id);
        $.ajax({
            url:"productos/eliminar/"+producto_id,
            type: "get",
            success:function(data)
            {
                $('#table_products').DataTable().ajax.reload();
            }
        })
    });


    $('#nuevo_producto').click(function(){
                $('.modal-title').text('Añadir un nuevo producto');
                $('#action_button').val('Añadir');
                $('#action').val('Añadir');
                $('#form_result').html('');


                $('#formModal').modal('show');
                });



            $('#sample_form').on('submit', function(event){
                event.preventDefault();
                var action_url = '';

                if($('#action').val() == 'Añadir')
                {
                action_url = "{{ route('productos.store') }}";
                }

                if($('#action').val() == 'Editar')
                {
                action_url = "{{ route('productos.update') }}";
                }

                console.log(action_url);
                console.log($(this).serialize());
                $.ajax({
                        url: action_url,
                        method:"POST",
                        data:$(this).serialize(),
                        dataType:"json",
                        success:function(data)
                        {
                            var html = '';
                            if(data.errors)
                            {
                                html = '<div class="alert alert-danger">';
                                for(var count = 0; count < data.errors.length; count++)
                                {
                                    html += '<p>' + data.errors[count] + '</p>';
                                }
                                html += '</div>';
                            }
                            if(data.success)
                            {
                                html = '<div class="alert alert-success">' + data.success + '</div>';
                                $('#sample_form')[0].reset();
                                $('#table_products').DataTable().ajax.reload();
                            }
                            $('#form_result').html(html);
                        }
                    });
                });


    });


</script>
@endsection
