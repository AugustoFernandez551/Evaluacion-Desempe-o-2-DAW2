<?php

class Model extends Conexion
{
    protected string $table = "";
    protected string $primaryKey = "id";
    protected string $select = "*";
    protected array $joins = [];
    protected array $whereBuilder = [];
    protected string $orderBy = "";
    protected string $limit = "";

    public function all(): array
    {
        return $this->get();
    }

    public function find(int $id): array|false
    {
        $sql = "SELECT {$this->table}.* FROM {$this->table} WHERE {$this->table}.{$this->primaryKey} = :id";
        $statement = $this->connect()->prepare($sql);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function insert(array $data): string|false
    {
        if ($data === []) {
            return false;
        }

        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $statement = $this->connect()->prepare($sql);

        foreach ($data as $column => $value) {
            $statement->bindValue(":" . $column, $value);
        }

        if (!$statement->execute()) {
            return false;
        }

        return $this->connect()->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        if ($data === []) {
            return false;
        }

        $assignments = [];
        foreach ($data as $column => $value) {
            $assignments[] = "{$column} = :{$column}";
        }

        $sql = "UPDATE {$this->table} SET " . implode(", ", $assignments)
            . " WHERE {$this->primaryKey} = :id";
        $statement = $this->connect()->prepare($sql);

        foreach ($data as $column => $value) {
            $statement->bindValue(":" . $column, $value);
        }

        $statement->bindValue(":id", $id, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function select(string $fields): static
    {
        $this->select = $fields;
        return $this;
    }

    public function where(array $conditions): static
    {
        foreach ($conditions as $condition) {
            $this->whereBuilder[] = $condition;
        }

        return $this;
    }

    public function orderBy(string $field, string $direction = "ASC"): static
    {
        $direction = strtoupper($direction);
        if (!in_array($direction, ["ASC", "DESC"], true)) {
            throw new InvalidArgumentException("Dirección de orden no válida");
        }

        $this->orderBy = "ORDER BY {$field} {$direction}";
        return $this;
    }

    public function limit(int $limit): static
    {
        $this->limit = "LIMIT " . max(0, $limit);
        return $this;
    }

    public function get(): array
    {
        $sql = "SELECT {$this->select} FROM {$this->table}";

        if ($this->joins) {
            $sql .= " " . implode(" ", $this->joins);
        }
        if ($this->whereBuilder) {
            $sql .= " WHERE " . implode(" AND ", $this->whereBuilder);
        }
        if ($this->orderBy !== "") {
            $sql .= " " . $this->orderBy;
        }
        if ($this->limit !== "") {
            $sql .= " " . $this->limit;
        }

        $statement = $this->connect()->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        $this->resetQuery();

        return $result;
    }

    public function first(): ?array
    {
        $this->limit(1);
        $result = $this->get();

        return $result[0] ?? null;
    }

    protected function resetQuery(): void
    {
        $this->select = "*";
        $this->whereBuilder = [];
        $this->orderBy = "";
        $this->limit = "";
    }
}
