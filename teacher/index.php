
<?php
session_start();

?>


<table>
     <tr>
          <td>
               <form method="POST" id="form-1" action=""></form>
               <input name="a" form="form-1">
          </td>
          <td><input name="b" form="form-1"></td>
          <td><input name="c" form="form-1"></td>
          <td><input type="submit" form="form-1"></td>
     </tr>

     <?php

     if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $a = $_POST["a"];
          $b = $_POST["b"];
          $c = $_POST["c"];
          
          echo " " .$a." ".$b." ".$c;
     }


     ?>
</table>