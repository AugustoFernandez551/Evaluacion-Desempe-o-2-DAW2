<?php

class FacultadesController extends Controller
{
    private array $errors = [];

    public function index(): void
    {
        $this->listar();
    }

    public function listar(): void
    {
        $facultades = $this->model
            ->where(["facultad.estado = 1"])
            ->orderBy("facultad.nombre")
            ->get();

        $this->views->render($this, "listar", ["facultades" => $facultades]);
    }

    public function registrar(): void
    {
        $this->views->render($this, "formulario", ["values" => [], "errors" => []]);
    }

    public function guardar(): void
    {
        $facultad = $this->inputDesdePost();

        if (!$this->formularioValido($facultad)) {
            $this->views->render($this, "formulario", ["values" => $facultad, "errors" => $this->errors]);
            return;
        }

        $this->model->insert($facultad + ["estado" => 1]);
        $this->redireccionarListado();
    }

    public function editar($id): void
    {
        $facultad = $this->model->find((int) $id);

        if ($facultad === false || (int) $facultad["estado"] !== 1) {
            $this->noEncontrada();
            return;
        }

        $this->views->render($this, "form_edit", ["facultad" => $facultad, "errors" => []]);
    }

    public function guardar_edit(): void
    {
        $id = (int) ($_POST["id"] ?? 0);
        $facultad = $this->inputDesdePost();

        if ($id <= 0 || !$this->formularioValido($facultad)) {
            $this->views->render($this, "form_edit", [
                "facultad" => $facultad + ["id" => $id],
                "errors" => $this->errors
            ]);
            return;
        }

        $this->model->update($id, $facultad);
        $this->redireccionarListado();
    }

    public function eliminar($id): void
    {
        $this->model->update((int) $id, ["estado" => 0]);
        $this->redireccionarListado();
    }

    private function inputDesdePost(): array
    {
        return [
            "nombre" => trim((string) ($_POST["nombre"] ?? "")),
            "abreviatura" => trim((string) ($_POST["abreviatura"] ?? ""))
        ];
    }

    private function formularioValido(array $facultad): bool
    {
        $this->errors = [];

        if ($facultad["nombre"] === "") {
            $this->errors[] = "El nombre es obligatorio.";
        }
        if ($facultad["abreviatura"] === "") {
            $this->errors[] = "La abreviatura es obligatoria.";
        }

        return $this->errors === [];
    }

    private function noEncontrada(): void
    {
        http_response_code(404);
        echo "<h1>Facultad no encontrada</h1>";
    }

    private function redireccionarListado(): never
    {
        header("Location: " . BASE_URL . "/facultades");
        exit;
    }
}
