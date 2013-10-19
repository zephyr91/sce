<?php

require '../bootstrap.php';

session_start();

//Open Database;
$mysqli = new mysqli('localhost', 'core', 'core', 'sce');
$email = $_SESSION['login'];

// Verifica se a entrada é por método get
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $select = "select endereco,telefonePrincipal,telefoneOpcional from USUARIO where email='$email'";

    $results = $mysqli->query($select);
    $dados = $results->fetch_row();

        /*
            Criando formulario para edição;
        */
        echo $twig->render('edit_user.html', array('endereco' => $dados[0], 'tel_principal' => $dados[1], 'tel_opcional' => $dados[2]));

}

// Verifica se a entrada é por método post
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

    /*
        Validando os dados do usuário;
    */
    $endereco=$_POST['ed_endereco'];
    $tel_princ=$_POST['ed_tel_princ'];
    $tel_op=$_POST['ed_tel_op'];

    $select = "select endereco,telefonePrincipal,telefoneOpcional from USUARIO where endereco='$endereco' and telefonePrincipal='$tel_princ' and telefoneOpcional='$tel_op' and email='$email';";

    $validate = $mysqli->query($select);
    $results = $validate->num_rows;
    
    if ($results != 0)
    {
        echo "erro";
    }

    else
    {
        $update_user = "UPDATE USUARIO SET endereco='$endereco', telefonePrincipal='$tel_princ', telefoneOpcional='$tel_op' WHERE email='$email';";
        $resultado_update = $mysqli->query($update_user);
        echo "sucesso";
    }
}
