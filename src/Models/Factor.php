<?php 

namespace Bytecraftnz\SupabasePhp\Models;

class Factor
{
  /** ID of the factor. */
  private string $id;

  /** Friendly name of the factor, useful to disambiguate between multiple factors. */
  private string $friendly_name;

  /**
   * Type of factor. `totp` and `phone` supported with this version
   */
  private string $factor_type;

  /** Factor's status. */
  private string $status;

  private string $created_at;
  private string $updated_at;


    public function __construct(
        array $data
    ) {
        $this->id = $data['id'] ?? '';
        $this->friendly_name = $data['friendly_name'] ?? '';
        $this->factor_type = $data['factor_type'] ?? '';
        $this->status = $data['status'] ?? '';
        $this->created_at = $data['created_at'] ?? '';
        $this->updated_at = $data['updated_at'] ?? '';
    }


    public function getId(): string
    {
        return $this->id;
    }
    public function getFriendlyName(): string
    {
        return $this->friendly_name;
    }
    public function getFactorType(): string
    {
        return $this->factor_type;
    }
    public function getStatus(): string
    {
        return $this->status;
    }
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'friendly_name' => $this->friendly_name,
            'factor_type' => $this->factor_type,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
    public function fromArray(array $data): self
    {
        return new self($data);
    }
    public function fromJson(string $json): self
    {
        $data = json_decode($json, true);
        return new self($data);
    }
}