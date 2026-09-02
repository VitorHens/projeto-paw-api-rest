<?php
namespace Api\Models;
use InvalidArgumentException;
use \JsonSerializable;

/**
 * Representa a entidade Cargo do sistema.
 *
 * Objetivo:
 * - Encapsular os dados de um cargo.
 * - Garantir integridade dos atributos via getters e setters.
 */
class Aluno implements JsonSerializable
{
    /** @var int Identificador único do cargo */
    private int $idAluno;

    /** @var string|null Nome do cargo */
    private string $nomeAluno = "";

    public function __construct()
    {
        // error_log("⬆️  Cargo::__construct()\n");
    }

    /**
     * Getter para idCargo
     * @return int|null Identificador único do cargo
     */
    public function getIdAluno(): ?int
    {
        return $this->idAluno;
    }

    /**
     * Define o ID do cargo.
     *
     * 🔹 Regra de domínio: garante que o ID seja sempre um número inteiro positivo.
     *
     * @param int $value Número inteiro positivo representando o ID do cargo.
     * @throws InvalidArgumentException se o valor for inválido.
     */
    public function setIdAluno(int $value): void
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException("alu_id deve ser um número inteiro.");
        }

        if ($value <= 0) {
            throw new InvalidArgumentException("alu_id deve ser maior que zero.");
        }

        $this->idAluno = $value;
    }

    /**
     * Getter para nomeCargo
     * @return string|null Nome do cargo
     */
    public function getNomeAluno(): ?string
    {
        return $this->nomeAluno;
    }

    /**
     * Define o nome do cargo.
     *
     * 🔹 Regra de domínio: garante que o nome seja sempre uma string não vazia
     * e com pelo menos 3 caracteres e no máximo 64.
     *
     * @param string $value Nome do cargo.
     * @throws InvalidArgumentException se o valor for inválido.
     */
    public function setNomeAluno(string $value): void
    {
        $nome = trim($value);

        if ($nome === '') {
            throw new InvalidArgumentException("alu_nome não pode ser vazio.");
        }

        $this->nomeAluno = $nome;
    }

    /**
     * Implementação da interface JsonSerializable
     *
     * Permite converter a entidade Cargo em formato JSON de forma segura e controlada.
     * Isso garante que apenas os atributos necessários sejam expostos ao cliente.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'alu_id' => $this->getIdAluno(),
            'alu_nome' => $this->getNomeAluno()
        ];
    }
}
