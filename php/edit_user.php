<?php

require '../bootstrap.php';

session_start();

//Open Database;
$dsn = 'mysql:dbname=sce;host=localhost';
$dbh = new PDO($dsn, 'core', 'core');
$dbh->exec("set names utf8");
$email = $_SESSION['login'];

// Verifica se a entrada é por método get
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $select = "select endereco,telefonePrincipal,telefoneOpcional,unidadeFederativa,municipio,bairro from USUARIO where email='$email'";

    $results = $dbh->query($select);
    $dados = $results->fetch();

        /*
            Criando formulario para edição;
        */
        echo $twig->render('edit_user.html', array('endereco' => $dados[0], 'tel_principal' => $dados[1], 'tel_opcional' => $dados[2], 'unidadeFederativa' => $dados[3], 'municipio' => $dados[4], 'bairro' => $dados[5]));

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
	$uf=$_POST['ed_uf'];
	$municipio=$_POST['ed_municipio'];
	$bairro=$_POST['ed_bairro'];

    $select = "select endereco,telefonePrincipal,telefoneOpcional,unidadeFederativa,municipio,bairro from USUARIO where endereco='$endereco' and telefonePrincipal='$tel_princ' and telefoneOpcional='$tel_op' and unidadeFederativa='$uf' and bairro='$bairro' and municipio='$municipio' and email='$email';";

    $validate = $dbh->query($select);
    $results = $validate->rowCount();
    
    if ($results != 0)
    {
        echo "erro";
    }

    else
    {
        $update_user = "UPDATE USUARIO SET endereco='$endereco', telefonePrincipal='$tel_princ', telefoneOpcional='$tel_op', unidadeFederativa='$uf', municipio='$municipio', bairro='$bairro' WHERE email='$email';";
        $resultado_update = $dbh->query($update_user);
        echo "sucesso";
    }
}
