<?php

require_once __DIR__ . '/../Models/classAdministrador.php';
require_once __DIR__ . '/../Models/classRecepcionista.php';

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

function verificaFuncionarioLogado(){
	if(!isset($_SESSION["funcionario"])){
		header("Location: ../../index.php");
	}
}

function verificaFuncionarioLogadoCadastro(){
	if(!isset($_SESSION["funcionario"])){
		header("Location: ../../../index.php");
	}
}
function verificarAdministradorLogado(){
	
	$a = new Administrador();
	$a->setFuncionarioId($_SESSION['funcionario']);
	if(empty($a->viewAdministrador())){
		header("Location: ../../index.php");
	}
}

function verificarAdministradorLogadoCadastro(){
	$a = new Administrador();
	$a->setFuncionarioId($_SESSION['funcionario']);
	if(empty($a->viewAdministrador())){
		header("Location: ../../../index.php");
	}
}

function verificarRecepcionistaLogado(){
	$r = new Recepcionista();
	$r->setFuncionarioId($_SESSION['funcionario']);
	if(empty($r->viewRecepcionista())){
		header("Location: ../../index.php");
	}
}

function verificarRecepcionistaLogadoCadastro(){
	$r = new Recepcionista();
	$r->setFuncionarioId($_SESSION['funcionario']);
	if(empty($r->viewRecepcionista())){
		header("Location: ../../../index.php");
	}
}

?>