<?=$cabecera ?>
<a class="btn btn-success" href="<?=base_url('crear')?>">Crear un Libro</a>
<br>
<br>
        <table class="table table-light">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- OJO abrir el foreach con dos puntos -->
                <?php foreach($libros as $libro): ?>
                    <tr>
                        <!-- = sustituye al echo -->
                        <td><?= $libro['id'];?></td>
                        <td>
                            <img class="img-thumbnail"
                             src="<?=base_url()?>/uploads/<?$libro['imagen'];?>"
                            width="100" alt="">
                            
                        </td>
                        <td><?=$libro['nombre'];?></td>
                        <td>
                            <a href="<?=base_url("editar/".$libro['id']);?>" class="btn btn-info" type="buttom">Editar</a> 
                            <a href="<?=base_url("borrar/".$libro['id']);?>" class="btn btn-danger" type="buttom">Borrar</a> 
                        </td>            
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
<?=$pie?>