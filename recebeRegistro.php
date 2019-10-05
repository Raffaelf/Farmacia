<?php

if ($_POST['password'] == $_POST['confirm-password']){
    echo "Logou";
} else {
    echo "<script>alert('Senhas não coincidem');window.location='/Admin/login.php'</script>";
}

?>