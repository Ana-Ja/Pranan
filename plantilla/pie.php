
</div> <!--  final id=wrappee -->
<footer>
<div class="footer panel-footer ">
      <ul>
        <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Inicio</a></li>
         <?php
            if (isset($_COOKIE["usuario"]) && $_COOKIE["usuario"]) { ?>
               <li><a href="<?php echo $raiz;?>socios/index2.php"><span class="glyphicon glyphicon-home"></span> INICIO</a></li>
               <?php } else {?>
                  <li><a href="<?php echo $raiz;?>index.php"><span class="glyphicon glyphicon-home"></span> INICIO</a></li>
               <?php } ?>
        <li><a href="contacto.php"><span class="glyphicon glyphicon-pencil"></span> Contactanos</a></li>
      </ul>
      <br/>
        <p id="copyright">&copy; 2011 Ana Jarauta </p>
 </div>
</footer>
</div>
</body>  <!--  final id=container -->
</html