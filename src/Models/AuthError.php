<?php

namespace Bytecraftnz\SupabasePhp\Models;

class AuthError
{

    private string $message;
    private string $code;
    private string $status;

    public function __construct(array $data)
    {
        $this->message = $data['message'] ?? '';
        $this->code = $data['code'] ?? '';
        $this->status = $data['status'] ?? '';
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCode(): string
    {
        return $this->code;
    }
    public function getStatus(): string
    {
        return $this->status;
    }


    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'code' => $this->code,
            'status' => $this->status,
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