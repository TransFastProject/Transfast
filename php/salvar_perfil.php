<?php
include "conexao.php";
session_start();
// banco do motorista abaixo
$nome = $_POST['nome'];
$genero = $_POST['genero'];
$data = $_POST['data_nascimento'];
$contato = $_POST['telefone'];

$_SESSION['nome'] = $nome;
$_SESSION['genero'] = $genero;
$_SESSION['dtnascimento'] = $data;
$_SESSION['telefone'] = $contato;

//adicionar genero abaixo depois
$sql->query("update motorista set nome='$nome', genero='$genero', data_nascimento='$data', telefone='$contato' where moto_cpf ='" . $_SESSION['moto_cpf'] . "'");

// banco do transporte abaixo
$monitor = $_POST['monitor'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$cep = $_POST ['cep'];
$bairro = $_POST['bairro'];
$codigo = $_POST['codigo'];

$_SESSION['monitor'] = $monitor;
$_SESSION['cidade_transporte'] = $cidade;
$_SESSION['estado_transporte'] = $estado;
$_SESSION['cep_transporte'] = $cep;
$_SESSION['bairro_transporte'] = $bairro;

$sql->query("update transporte set monitor='$monitor', cidade='$cidade', estado='$estado', cep='$cep', bairro='$bairro' where moto_cpf ='" . $_SESSION['moto_cpf'] . "'");


header("Location: ../php/gere_perfil.php");
?>