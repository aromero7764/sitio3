<?php include("../template/cabecera.php"); ?>


<?php

$txtID = (isset($_POST['txtID'])) ?         $_POST['txtID'] : "";
$txtNombre=(isset($_POST['txtNombre'])) ?    $_POST['txtNombre'] : "";
$txtImagen=(isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
$accion=(isset($_POST['accion'])) ? $_POST['accion']:"";

include("../config/bd.php"); 


switch($accion) {
            case "agregar":
        
                $sentenciaSQL= $conexion->prepare("INSERT INTO libros (nombre, imagen) VALUES (:nombre,:imagen);");
                $sentenciaSQL->bindParam(':nombre' , $txtNombre);

                $fecha=new DateTime();
                $nombreArchivo=($txtImagen!="") ? $fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

                $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
                if ($tmpImagen!="") {

                    move_uploaded_file($tmpImagen, "../../img/".$nombreArchivo);

                }

                $sentenciaSQL->bindParam(':imagen' , $nombreArchivo);
                $sentenciaSQL->execute();

                header("Location:productos.php");
                    break;

            case "modificar":
                    //echo "Presionado el boton modificar";
                    $sentenciaSQL= $conexion->prepare("UPDATE libros SET nombre=:nombre WHERE id=:id");
                    $sentenciaSQL->bindParam(':nombre',$txtNombre);
                    $sentenciaSQL->bindParam(':id',$txtID);
                    $sentenciaSQL->execute();

                    if($txtImagen!="") {

                        $fecha=new DateTime();
                        $nombreArchivo=($txtImagen!="") ? $fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

                        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
                        
                        move_uploaded_file($tmpImagen, "../../img/".$nombreArchivo);

                        $sentenciaSQL= $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
                        $sentenciaSQL->bindParam(':id',$txtID);
                        $sentenciaSQL->execute();
                        $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

                        if(isset($libro["imagen"]) && ($libro["imagen"]!="imagen.jpg")) {

                            if(file_exists("../../img/".$libro["imagen"])) {
                                unlink("../../img/".$libro["imagen"]);
                            }

                        }


                    $sentenciaSQL= $conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
                    $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
                    $sentenciaSQL->bindParam(':id',$txtID);
                    $sentenciaSQL->execute();
                }

                header("Location:productos.php");

                    break;
            case "cancelar":
                        //echo "Presionado el boton cancelar";
                        header("Location:productos.php");
                        break;


                        case "Seleccionar":
                            //echo "Presionado el boton Seleccionar";
                            $sentenciaSQL= $conexion->prepare("SELECT * FROM libros WHERE id=:id");
                            $sentenciaSQL->bindParam(':id',$txtID);
                            $sentenciaSQL->execute();
                            $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
                            $txtNombre=$libro['nombre'];
                            $txtImagen=$libro['imagen'];
                            break;
                        
                        case "Borrar":

                            $sentenciaSQL= $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
                            $sentenciaSQL->bindParam(':id',$txtID);
                            $sentenciaSQL->execute();
                            $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

                            if(isset($libro["imagen"]) && ($libro["imagen"]!="imagen.jpg")) {

                                if(file_exists("../../img/".$libro["imagen"])) {
                                    unlink("../../img/".$libro["imagen"]);
                                }

                            }

                            $sentenciaSQL= $conexion->prepare("DELETE FROM libros WHERE libros . id=:id");
                            $sentenciaSQL->bindParam(':id',$txtID);
                            $sentenciaSQL->execute();

                            header("Location:productos.php");
                            
                                //echo "Presionado el boton Borrar";
                                //DELETE FROM libros WHERE `libros`.`id` = 3"
                                break;

}

$sentenciaSQL= $conexion->prepare("SELECT * FROM libros");
$sentenciaSQL->execute();
$listaLibros=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?>

<div class="col-md-5">
<!-- //Formulario de agregar libros -->

    <div class="card">
        <div class="card-header">
            Datos de Libros
        </div>

        <div class="card-body">
        
        <form   method="POST" enctype="multipart/form-data">

            <div class = "form-group">
            <label for="textID">ID</label>
            <input type="text" require readonly class="form-control" value="<?php echo $txtID;?>" name="txtID" id="txtID"  placeholder="ID">
            </div>

            <div class = "form-group">
            <label for="textnombre">Nombre:</label>
            <input type="text" require class="form-control" value="<?php echo $txtNombre;?>" name="txtNombre" id="txtnombre"  placeholder="Ingrese el nombre">
            </div>

            <div class = "form-group">
            <label for="textImagen">Imagen:</label>

           <!--  <?php echo $txtImagen;?> -->
            <br/>
            <?php
                if($txtImagen!="") {  ?>

                    <img class="img-thumbail rounded" src="../../img/<?php echo $txtImagen;?>" width="50" alt="">
           

                    <?php } ?>
            

            <input type="file" class="form-control" name="txtImagen" id="txtImagen"  placeholder="ID">
            </div>

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":"" ?> value="agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" <?php echo ($accion!=="Seleccionar")?"disabled":"" ?> value="modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" <?php echo ($accion!=="Seleccionar")?"disabled":"" ?> value="cancelar" class="btn btn-info">Cancelar</button>
                </div>

        </form>



        </div>
       
    </div>

    
    
    
    
</div>
<div class="col-md-7">

<!-- //tabla de libros (Mostrar los datos del libro) -->

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Imagenes</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>          <!-- estructura del foreach -->
                    <?php foreach($listaLibros as $libro) { ?>

                    
        <tr>
            <td><?php echo $libro['id'];?></td>
            <td><?php echo $libro['nombre'];?></td>

            <td><img src="../../img/<?php echo $libro['imagen'];?>" width="50" alt="">
            <!-- <?php echo $libro['imagen'];?></td> -->

            <td>

           
                
                        <form method="post">
                                <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id'];?>"/>
                                
                                <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>
                                
                                <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>

                        </form>
                        
            </td>
        </tr>
       <?php } ?>

    </tbody>
</table>
    
</div>

<?php include("../template/pie.php") ?>
use PDO;
use DateTime;
