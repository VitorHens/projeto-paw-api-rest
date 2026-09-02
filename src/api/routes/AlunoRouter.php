<?php

namespace Api\Routes;

use Slim\App;
use Api\Controllers\AlunoController;
use Api\Middlewares\Aluno\ValidateAlunoBody;
use Api\Middlewares\Aluno\ValidateAlunoId;


class AlunoRouter
{
    /**
     * Instância da aplicação Slim.
     *
     * @var App
     */
    private App $app;

    /**
     * Recebe a instância principal da aplicação.
     *
     * @param App $app Aplicação Slim.
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Registra todas as rotas relacionadas ao recurso Aluno.
     *
     * Estrutura esperada do JSON:
     *
     * {
     *   "Aluno": {
     *     "nomeAluno": "teste"
     *   }
     * }
     *
     * IMPORTANTE:
     * No Slim Framework, os middlewares executam em ordem inversa
     * à ordem em que são adicionados com ->add().
     *
     * O último middleware adicionado executa primeiro.
     *
     * @return void
     */
    public function setupRoutes(): void
    {
        /**
         * =========================================================
         * POST /Alunos
         * =========================================================
         * Cria um novo Aluno.
         *
         * Body:
         * {
         *   "Aluno": {
         *     "nomeAluno": "teste"
         *   }
         * }
         *
         * Ordem de execução:
         * 1. ValidateAlunoBody
         * 2. AlunoController::createController
         */
        $this->app->post(
            '/Alunos',
            [AlunoController::class, 'createController']
        )
            ->add(ValidateAlunoBody::class);

        /**
         * =========================================================
         * GET /Alunos
         * =========================================================
         * Lista todos os Alunos.
         *
         * Ordem de execução:
         * 1. AlunoController::findAllController
         */
        $this->app->get(
            '/Alunos',
            [AlunoController::class, 'findAllController']
        );

        /**
         * =========================================================
         * GET /Alunos/count
         * =========================================================
         * Retorna a quantidade total de Alunos.
         *
         * Ordem de execução:
         * 1. AlunoController::countController
         */
        $this->app->get(
            '/Alunos/count',
            [AlunoController::class, 'countController']
        );

        /**
         * =========================================================
         * GET /Alunos/{idAluno}
         * =========================================================
         * Busca um Aluno pelo ID.
         *
         * Ordem de execução:
         * 1. ValidateAlunoId
         * 2. AlunoController::findByIdController
         */
        $this->app->get(
            '/Alunos/{alu_id}',
            [AlunoController::class, 'findByIdController']
        )
            ->add(ValidateAlunoId::class);

        /**
         * =========================================================
         * PUT /Alunos/{idAluno}
         * =========================================================
         * Atualiza um Aluno existente.
         *
         * Body:
         * {
         *   "Aluno": {
         *     "nomeAluno": "teste"
         *   }
         * }
         *
         * Ordem de execução:
         * 1. ValidateAlunoId
         * 2. ValidateAlunoBody
         * 3. AlunoController::updateController
         */
        $this->app->put(
            '/Alunos/{alu_id}',
            [AlunoController::class, 'updateController']
        )
            ->add(ValidateAlunoBody::class)
            ->add(ValidateAlunoId::class);

        /**
         * =========================================================
         * DELETE /Alunos/{idAluno}
         * =========================================================
         * Remove um Aluno pelo ID.
         *
         * Ordem de execução:
         * 1. ValidateAlunoId
         * 2. AlunoController::deleteController
         */
        $this->app->delete(
            '/Alunos/{alu_id}',
            [AlunoController::class, 'deleteController']
        )
            ->add(ValidateAlunoId::class);
    }
}