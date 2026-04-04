<?php
session_start();
session_destroy(); 


header('Location: ../views/acceuil.php?statut=deconnecte');
exit();