<?php  
   $status = session_status();
   if  (isset( $_SESSION['nombre_usuarios'] ))  {  
?>	

<div class="profile clearfix">
             
             
              <div class="profile_pic">
               <!--<img src="view/images/usuario.jpg" alt="view." class="img-circle profile_img"> --> 
                <img src="view/DevuelveImagenView.php?id_valor=<?php echo $_SESSION['id_usuarios']; ?>&id_nombre=id_usuarios&tabla=usuarios&campo=fotografia_usuarios"  alt="view." class="img-circle profile_img">
                    
              </div>
              <div class="profile_info">
                <span>Hola</span>
                <h2><?php echo $_SESSION['nombre_usuarios'];?></h2>
              </div>
              
              
 </div>
 
 <?php }?>