<?php

namespace Api\Services;

use Api\Models\Aluno;
use Api\DAO\AlunoDAO;
use Api\Http\ErrorResponse;
use stdClass;

/**
 * Camada de regra de negócio da entidade Aluno.
 *
 * Fluxo:
 * Controller -> Service -> DAO -> Banco
 */
class AlunoService
{
    /**
     * DAO responsável pelo acesso aos dados.
     *
     * @var AlunoDAO
     */
    private AlunoDAO $AlunoDAO;

    /**
     * Injeção de dependência.
     *
     * @param AlunoDAO $AlunoDAODependency
     */
    public function __construct(AlunoDAO $AlunoDAODependency)
    {
        error_log("⬆️ AlunoService::__construct()");
        $this->AlunoDAO = $AlunoDAODependency;
    }

    /**
     * Cria um novo Aluno.
     *
     * Regras:
     * - Não permite nome duplicado.
     *
     * @param array $objPHP
     * @return Aluno
     * @throws ErrorResponse
     */
    public function createService(stdClass $objPHP): Aluno
    {
        error_log("🟣 AlunoService::createService()");

        $Aluno = new Aluno();
        $Aluno->setNomeAluno($objPHP->Aluno->alu_nome);

        /**
         * Verifica duplicidade.
         */
        $resultado = $this->AlunoDAO->findByField(
            'alu_nome',
            $Aluno->getNomeAluno()
        );

        if (count($resultado) > 0) {
            throw new ErrorResponse(
                400,
                "Aluno já existe",
                [
                    "message" =>
                        "O Aluno {$Aluno->getNomeAluno()} já existe"
                ]
            );
        }

        return $this->AlunoDAO->create($Aluno);
    }

    /**
     * Retorna quantidade total.
     *
     * @return int
     */
    public function countService(): int
    {
        error_log("🟣 AlunoService::countService()");
        return $this->AlunoDAO->count();
    }

    /**
     * Lista todos os Alunos.
     *
     * @return array
     */
    public function findAllService(): array
    {
        error_log("🟣 AlunoService::findAllService()");
        return $this->AlunoDAO->findAll();
    }

    /**
     * Busca Aluno por ID.
     *
     * @param int $idAluno
     * @return Aluno|null
     */
    public function findByIdService(int $idAluno): ?Aluno
    {
        error_log("🟣 AlunoService::findByIdService()");

        $Aluno = new Aluno();
        $Aluno->setIdAluno($idAluno);

        return $this->AlunoDAO->findById(
            $Aluno->getIdAluno()
        );
    }

    /**
     * Atualiza Aluno existente.
     *
     * Regras:
     * - O Aluno precisa existir.
     * - Se não existir, lança erro 404.
     *
     * @param int $idAluno
     * @param string $nomeAluno
     * @return bool
     * @throws ErrorResponse
     */
    public function updateService(int $idAluno, string $nomeAluno): bool
    {
        error_log("🟣 AlunoService::updateService()");

        /**
         * Verifica existência.
         */
        $AlunoExistente = $this->AlunoDAO->findById($idAluno);

        if (!$AlunoExistente) {
            throw new ErrorResponse(
                404,
                "Aluno não encontrado",
                [
                    "message" =>
                        "Não existe Aluno com id {$idAluno}"
                ]
            );
        }

        /**
         * Monta objeto atualizado.
         */
        $Aluno = new Aluno();
        $Aluno->setIdAluno($idAluno);
        $Aluno->setNomeAluno($nomeAluno);

        return $this->AlunoDAO->update($Aluno);
    }

    /**
     * Remove Aluno existente.
     *
     * Regras:
     * - O Aluno precisa existir.
     * - Se não existir, lança erro 404.
     *
     * @param int $idAluno
     * @return bool
     * @throws ErrorResponse
     */
    public function deleteService(int $idAluno): bool
    {
        error_log("🟣 AlunoService::deleteService()");

        /**
         * Verifica existência.
         */
        $AlunoExistente = $this->AlunoDAO->findById($idAluno);

        if (!$AlunoExistente) {
            throw new ErrorResponse(
                404,
                "Aluno não encontrado",
                [
                    "message" =>
                        "Não existe Aluno com id {$idAluno}"
                ]
            );
        }

        /**
         * Monta objeto para exclusão.
         */
        $Aluno = new Aluno();
        $Aluno->setIdAluno($idAluno);

        return $this->AlunoDAO->delete($Aluno);
    }
}