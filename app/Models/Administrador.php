<?php

namespace ClinicaOdontologica\Models;

class Administrador extends Funcionario
{
    private $funcionario_id;
    private $nome_usuario;
    private $senha;

    public function __construct()
    {
        $database = new \Database();
        $dbSet = $database->dbSet();
        $this->conn = $dbSet;
    }

    public function getFuncionarioId()
    {
        return $this->funcionario_id;
    }

    public function getNomeUsuario()
    {
        return $this->nome_usuario;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setFuncionarioId($funcionario_id)
    {
        $this->funcionario_id = $funcionario_id;
    }

    public function setNomeUsuario($nome_usuario)
    {
        if (strlen($nome_usuario) <= 255) {
            $this->nome_usuario = $nome_usuario;
            return 1;
        }
        return 0;
    }

    public function setSenha($senha)
    {
        // store only the hashed password for storage
        $this->senha = password_hash($senha, PASSWORD_DEFAULT);
    }

    public function insert()
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO administrador(funcionario_id, nome_usuario, senha) VALUES(:funcionario_id, :nome_usuario, :senha)");
            $stmt->bindParam(":funcionario_id", $this->funcionario_id);
            $stmt->bindParam(":nome_usuario", $this->nome_usuario);
            $stmt->bindParam(":senha", $this->senha);
            $stmt->execute();
            return $this->conn->lastInsertId();
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return 0;
        }
    }

    public function edit()
    {
        try {
            $stmt = $this->conn->prepare("UPDATE administrador SET nome_usuario = :nome_usuario, senha = :senha WHERE funcionario_id = :funcionario_id");
            $stmt->bindParam(":funcionario_id", $this->funcionario_id);
            $stmt->bindParam(":nome_usuario", $this->nome_usuario);
            $stmt->bindParam(":senha", $this->senha);
            $stmt->execute();
            return 1;
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return 0;
        }
    }

    public function delete()
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM administrador WHERE funcionario_id = :funcionario_id");
            $stmt->bindParam(":funcionario_id", $this->funcionario_id);
            $stmt->execute();
            return 1;
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return 0;
        }
    }

    public function existe($senha = null)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM administrador WHERE nome_usuario = :nome_usuario");
            $stmt->bindParam(":nome_usuario", $this->nome_usuario);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_OBJ);
            if (!empty($result) && !empty($senha)) {
                // modern verification
                if (password_verify($senha, $result->senha)) {
                    return $result->funcionario_id;
                }
                // legacy SHA1 fallback: if stored hash looks like SHA1, verify and migrate
                if (is_string($result->senha) && preg_match('/^[0-9a-f]{40}$/i', $result->senha)) {
                    if (hash_equals($result->senha, sha1($senha))) {
                        // migrate to password_hash
                        try {
                            $newHash = password_hash($senha, PASSWORD_DEFAULT);
                            $u = $this->conn->prepare("UPDATE administrador SET senha = :senha WHERE funcionario_id = :funcionario_id");
                            $u->bindParam(':senha', $newHash);
                            $u->bindParam(':funcionario_id', $result->funcionario_id);
                            $u->execute();
                        } catch (\PDOException $e) {
                            error_log('Failed to migrate administrador password for id ' . $result->funcionario_id . ': ' . $e->getMessage());
                        }
                        return $result->funcionario_id;
                    }
                }
            }
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function viewAll()
    {
        $stmt = $this->conn->prepare("SELECT * FROM administrador JOIN funcionario ON administrador.funcionario_id = funcionario.id ");
        $stmt->execute();
        return $stmt;
    }

    public function viewAdministrador()
    {
        $stmt = $this->conn->prepare("SELECT * FROM administrador WHERE funcionario_id = :funcionario_id");
        $stmt->bindParam(":funcionario_id", $this->funcionario_id);
        $stmt->execute();
        $resultado = $stmt->fetch(\PDO::FETCH_OBJ);
        return $resultado;
    }

}
