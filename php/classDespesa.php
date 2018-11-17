<?php

require_once 'database.php';

class Despesa{

	private $id;
	private $nome;
	private $data;
	private $quantia;

	public function __construct(){
		$database = new Database();
		$dbSet = $database->dbSet();
		$this->conn = $dbSet;
	}

	public function getId(){
		return $this->id;
	}

	public function getNome(){
		return $this->nome;
	}

	public function getData(){
		return $this->data;
	}

	public function getQuantia(){
		return $this->quantia;
	}

	public function getTipo(){
			return $this->tipo;
	}

	public function getSituacao(){
		return $this->situacao;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function setNome($nome){
		if(strlen($nome) <= 45){
			$this->nome = $nome;
			return 1;
		}
		return 0;
	}

	public function setData($data){
		$this->data = $data;
	}

	public function setQuantia($quantia){
		if($quantia > 0){
			$this->quantia = $quantia;
			return 1;
		}
		return 0;
	}

	public function setTipo($tipo){
		if(strlen($tipo) <= 45){
			$this->tipo = $tipo;
			return 1;
		}else{
			return 0;
		}
	}

	public function setSituacao($situacao){
		$this->situacao = $situacao;
	}

	public function insert(){
		try{	
			$stmt = $this->conn->prepare("INSERT INTO despesa(nome,data,quantia,tipo,situacao) VALUES(:nome, :data, :quantia, :tipo, :situacao)");
			$stmt->bindParam(":nome", $this->nome);
			$stmt->bindParam(":data", $this->data);
			$stmt->bindParam(":quantia", $this->quantia);
			$stmt->bindParam(":tipo", $this->tipo);
			$stmt->bindParam(":situacao", $this->situacao);
			$stmt->execute();
			return 1;
		}catch(PDOException $e){
			echo $e->getMessage();
			return 0;	
		}
	}	

	public function edit(){
		try{
			$stmt = $this->conn->prepare("UPDATE despesa SET nome = :nome, data = :data, quantia = :quantia, tipo = :tipo, situacao = :situacao WHERE id = :id");
			$stmt->bindParam(":id", $this->id);
			$stmt->bindParam(":nome", $this->nome);
			$stmt->bindParam(":data", $this->data);
			$stmt->bindParam(":quantia", $this->quantia);
			$stmt->bindParam(":tipo", $this->tipo);
			$stmt->bindParam(":situacao", $this->situacao);
			$stmt->execute();
			return 1;
		}catch(PDOException $e){
			echo $e->getMessage();
			return 0;
		}
	}

	public function delete(){
		try{
			$stmt = $this->conn->prepare("DELETE FROM despesa WHERE id = :id");
			$stmt->bindParam(":id", $this->id);
			$stmt->execute();
			return 1;
		}catch(PDOExcecption $e){
			echo $e->getMessage();
			return 0;
		}
	}

}

?>