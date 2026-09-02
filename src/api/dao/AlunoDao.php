<?php

namespace Api\DAO;

use Api\Models\Aluno;
use Api\Database\MysqlDatabase;
use Exception;

/**
 * Classe responsável pelo acesso aos dados da entidade Aluno.
 *
 * Camadas:
 * Controller -> Service -> DAO -> Banco de Dados
 *
 * Objetivo:
 * Centralizar todas as operações SQL relacionadas à tabela Aluno.
 */
class AlunoDAO
{
    /**
     * Instância de conexão com banco de dados.
     *
     * @var MysqlDatabase
     */
    private MysqlDatabase $database;

    /**
     * Recebe a conexão via injeção de dependência.
     *
     * @param MysqlDatabase $databaseInstance
     */
    public function __construct(MysqlDatabase $databaseInstance)
    {
        $this->database = $databaseInstance;

        error_log("⬆️ AlunoDAO::__construct()");
    }

    /**
     * Insere um novo Aluno no banco.
     *
     * @param Aluno $objAluno
     * @return Aluno gerado
     * @throws Exception
     */
    public function create(Aluno $objAluno): Aluno
    {
        error_log("🟢 AlunoDAO::create()");

        /**
         * SQL de inserção.
         */
        $sql = "
            INSERT INTO alunos (alu_nome)
            VALUES (:alu_nome)
        ";

        /**
         * Valores da query.
         */
        $parametros = [
            ':nomeAluno' => $objAluno->getNomeAluno()
        ];

        /**
         * Prepara e executa.
         */
        $stmt = $this->database->getConnection()->prepare($sql);

        if (!$stmt->execute($parametros)) {
            throw new Exception("Erro ao cadastrar Aluno.");
        }

        /**
         * Retorna ID criado.
         */
        $novoID = (int) $this->database->getConnection()->lastInsertId();
        $objAluno->setIdAluno($novoID);
        return $objAluno;
    }

    /**
     * Remove um Aluno pelo ID.
     *
     * @param Aluno $objAlunoModel
     * @return bool
     */
    public function delete(Aluno $objAlunoModel): bool
    {
        error_log("🟢 AlunoDAO::delete()");

        /**
         * SQL de exclusão.
         */
        $sql = "
            DELETE FROM alunos
            WHERE alu_id = :alu_id
        ";

        /**
         * Valores da query.
         */
        $parametros = [
            ':alu_id' => $objAlunoModel->getIdAluno()
        ];

        /**
         * Executa exclusão.
         */
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);

        /**
         * True se removeu registro.
         */
        return $stmt->rowCount() > 0;
    }

    /**
     * Atualiza um Aluno existente.
     *
     * @param Aluno $objAlunoModel
     * @return bool
     */
    public function update(Aluno $objAlunoModel): bool
    {
        error_log("🟢 AlunoDAO::update()");

        /**
         * SQL de atualização.
         */
        $sql = "
            UPDATE alunos
            SET alu_nome = :alu_nome
            WHERE alu_id = :alu_id
        ";

        /**
         * Valores da query.
         */
        $parametros = [
            ':alu_nome' => $objAlunoModel->getNomeAluno(),
            ':alu_id' => $objAlunoModel->getIdAluno()
        ];

        /**
         * Executa atualização.
         */
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);

        /**
         * True se alterou registro.
         */
        return $stmt->rowCount() > 0;
    }

    /**
     * Retorna todos os Alunos cadastrados.
     *
     * @return array
     */
    public function findAll(): array
    {
        error_log("🟢 AlunoDAO::findAll()");

        /**
         * Consulta todos os registros.
         */
        $sql = "SELECT * FROM alunos";

        /**
         * Executa consulta.
         */
        $stmt = $this->database->getConnection()->query($sql);

        /**
         * Matriz de arrays.
         */
        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        /**
         * Lista final de objetos Aluno.
         */
        $Alunos = [];

        /**
         * Converte cada linha em objeto Aluno.
         */
        foreach ($matrizArrays as $linhaMatriz) {
            $Aluno = new Aluno();

            $Aluno->setIdAluno((int) $linhaMatriz['alu_id']);
            $Aluno->setNomeAluno($linhaMatriz['alu_nome']);

            $Alunos[] = $Aluno;
        }

        /**
         * Retorna lista pronta.
         */
        return $Alunos;
    }

    /**
     * Retorna total de Alunos cadastrados.
     *
     * @return int
     */
    public function count(): int
    {
        error_log("🟢 AlunoDAO::count()");

        /**
         * SQL de contagem.
         */
        $sql = "SELECT COUNT(*) AS qtd FROM alunos";

        /**
         * Executa consulta.
         */
        $stmt = $this->database->getConnection()->query($sql);

        /**
         * Resultado único.
         */
        $linhaMatriz = $stmt->fetch(\PDO::FETCH_ASSOC);

        /**
         * Retorna total.
         */
        return (int) $linhaMatriz['qtd'];
    }

    /**
     * Busca Aluno pelo ID.
     *
     * @param int $idAluno
     * @return Aluno|null
     */
    public function findById(int $idAluno): ?Aluno
    {
        error_log("🟢 AlunoDAO::findById()");

        /**
         * Busca reutilizando método genérico.
         */
        $resultado = $this->findByField('alu_id', $idAluno);

        /**
         * Se encontrou registro.
         */
        if (!empty($resultado)) {
            return $resultado[0];
        }

        /**
         * Não encontrado.
         */
        return null;
    }

    /**
     * Busca por campo específico.
     *
     * @param string $field
     * @param mixed $value
     * @return array
     * @throws Exception
     */
    public function findByField(string $field, $value): array
    {
        error_log("🟢 AlunoDAO::findByField()");

        /**
         * Campos permitidos.
         */
        $camposPermitidos = [
            'alu_id',
            'alu_nome'
        ];

        /**
         * Valida campo informado.
         */
        if (!in_array($field, $camposPermitidos)) {
            throw new Exception("Campo inválido.");
        }

        /**
         * SQL dinâmica segura.
         */
        $sql = "SELECT * FROM alunos WHERE $field = :value";

        /**
         * Prepara consulta.
         */
        $stmt = $this->database->getConnection()->prepare($sql);

        /**
         * Executa busca.
         */
        $stmt->execute([
            ':value' => $value
        ]);

        /**
         * Matriz retornada.
         */
        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        /**
         * Lista final de objetos Aluno.
         */
        $Alunos = [];

        /**
         * Converte linhas em objetos.
         */
        foreach ($matrizArrays as $linhaMatriz) {
            $Aluno = new Aluno();

            $Aluno->setIdAluno((int) $linhaMatriz['alu_id']);
            $Aluno->setNomeAluno($linhaMatriz['alu_nome']);

            $Alunos[] = $Aluno;
        }

        /**
         * Retorna lista.
         */
        return $Alunos;
    }
}