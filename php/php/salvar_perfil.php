<?php
include "conexao.php";
session_start();
// banco do motorista abaixo
$nome = $_POST['nome'];
$genero = $_POST['genero'];
$data = $_POST['data_nascimento'];
$contato = $_POST['telefone'];


//adicionar genero abaixo depois
$sql->query("update motorista set nome='$nome', genero='$genero', data_nascimento='$data', telefone='$contato' where moto_cpf ='" . $_SESSION['moto_cpf'] . "'");

// banco do transporte abaixo
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$cep = $_POST ['cep'];
$bairro = $_POST['bairro'];

$sql->query("update motorista set cidade='$cidade', estado='$estado', cep='$cep', bairro='$bairro' where moto_cpf ='" . $_SESSION['moto_cpf'] . "'");


header("Location: ../php/gere_perfil.php");
?>