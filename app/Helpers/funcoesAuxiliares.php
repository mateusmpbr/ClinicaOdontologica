<?php

require_once __DIR__ . '/../Models/classAdministrador.php';
require_once __DIR__ . '/../Models/classRecepcionista.php';

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

function verificaFuncionarioLogado(){
	if(!isset($_SESSION["funcionario"])){
		header("Location: ../../index.php");
		exit;
	}
}

function verificaFuncionarioLogadoCadastro(){
	if(!isset($_SESSION["funcionario"])){
		header("Location: ../../../index.php");
		exit;
	}
}
function verificarAdministradorLogado(){
	
	$a = new Administrador();
	$a->setFuncionarioId($_SESSION['funcionario']);
	if(empty($a->viewAdministrador())){
			header("Location: ../../index.php");
			exit;
	}
}

function verificarAdministradorLogadoCadastro(){
	$a = new Administrador();
	$a->setFuncionarioId($_SESSION['funcionario']);
	if(empty($a->viewAdministrador())){
			header("Location: ../../../index.php");
			exit;
	}
}

function verificarRecepcionistaLogado(){
	$r = new Recepcionista();
	$r->setFuncionarioId($_SESSION['funcionario']);
	if(empty($r->viewRecepcionista())){
			header("Location: ../../index.php");
			exit;
	}
}

function verificarRecepcionistaLogadoCadastro(){
	$r = new Recepcionista();
	$r->setFuncionarioId($_SESSION['funcionario']);
	if(empty($r->viewRecepcionista())){
			header("Location: ../../../index.php");
			exit;
	}
}

?>