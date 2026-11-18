<?php

class DocentesController extends Controller
{
    private array $errors = [];
    private const CATEGORIAS = ["AUXILIAR", "ASOCIADO", "PRINCIPAL"];
    private const DEDICACIONES = ["DEDICACION EXCLUSIVA-DE", "TIEMPO COMPLETO-TC", "TIEMPO PARCIAL-TP"];

    public function index(): void
    {
        $this->listar();
    }

    public function listar(): void
    {
        $docentes = $this->model
            ->select("docente.*, facultad.nombre AS facultad_nombre")
            ->where(["docente.estado = 1"])
            ->orderBy("docente.apellidos")
            ->get();

        $this->views->render($this, "listar", ["docentes" => $docentes]);
    }

    public function registrar(): void
    {
        $this->mostrarFormulario("formulario", [], []);
    }

    public function guardar(): void
    {
        $docente = $this->inputDesdePost();

        if (!$this->formularioValido($docente)) {
            $this->mostrarFormulario("formulario", $docente, $this->errors);
            return;
        }

        $this->model->insert($docente + ["estado" => 1]);
        $this->redireccionarListado();
    }

    public function editar($id): void
    {
        $docente = $this->model->find((int) $id);

        if ($docente === false || (int) $docente["estado"] !== 1) {
            $this->noEncontrado();
            return;
        }

        $this->mostrarFormulario("form_edit", $docente, []);
    }

    public function guardar_edit(): void
    {
        $id = (int) ($_POST["id"] ?? 0);
        $docente = $this->inputDesdePost();

        if ($id <= 0 || !$this->formularioValido($docente)) {
            $this->mostrarFormulario("form_edit", $docente + ["id" => $id], $this->errors);
            return;
        }

        $this->model->update($id, $docente);
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
            "id_facultad" => (int) ($_POST["id_facultad"] ?? 0),
            "dni" => trim((string) ($_POST["dni"] ?? "")),
            "apellidos" => trim((string) ($_POST["apellidos"] ?? "")),
            "nombres" => trim((string) ($_POST["nombres"] ?? "")),
            "correo" => trim((string) ($_POST["correo"] ?? "")),
            "categoria" => (string) ($_POST["categoria"] ?? ""),
            "dedicacion" => (string) ($_POST["dedicacion"] ?? "")
        ];
    }

    private function formularioValido(array $docente): bool
    {
        $this->errors = [];

        foreach (["dni", "apellidos", "nombres", "correo"] as $campo) {
            if ($docente[$campo] === "") {
                $this->errors[] = "Todos los datos del docente son obligatorios.";
                break;
            }
        }
        if (!$this->model->facultadExiste($docente["id_facultad"])) {
            $this->errors[] = "La facultad no existe o no está activa.";
        }
        if (!in_array($docente["categoria"], self::CATEGORIAS, true)) {
            $this->errors[] = "La categoría no es válida.";
        }
        if (!in_array($docente["dedicacion"], self::DEDICACIONES, true)) {
            $this->errors[] = "La dedicación no es válida.";
        }

        return $this->errors === [];
    }

    private function mostrarFormulario(string $view, array $docente, array $errors): void
    {
        $this->views->render($this, $view, [
            "docente" => $docente,
            "facultades" => $this->model->facultadesActivas(),
            "categorias" => self::CATEGORIAS,
            "dedicaciones" => self::DEDICACIONES,
            "errors" => $errors
        ]);
    }

    private function noEncontrado(): void
    {
        http_response_code(404);
        echo "<h1>Docente no encontrado</h1>";
    }

    private function redireccionarListado(): never
    {
        header("Location: " . BASE_URL . "/docentes");
        exit;
    }
}
