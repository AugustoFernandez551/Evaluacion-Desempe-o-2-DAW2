<?php

class DocentesModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = "docente";
        $this->joins = ["JOIN facultad ON facultad.id = docente.id_facultad"];
    }

    public function facultadesActivas(): array
    {
        $statement = $this->connect()->prepare(
            "SELECT id, nombre FROM facultad WHERE estado = 1 ORDER BY nombre"
        );
        $statement->execute();

        return $statement->fetchAll();
    }

    public function facultadExiste(int $id): bool
    {
        $statement = $this->connect()->prepare(
            "SELECT id FROM facultad WHERE id = :id AND estado = 1"
        );
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        return (bool) $statement->fetch();
    }
}
