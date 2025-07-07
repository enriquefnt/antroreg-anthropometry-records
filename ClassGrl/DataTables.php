<?php

namespace ClassGrl;

class DataTables
{
    private $pdo;
    private $table;
    private $primaryKey;

    public function __construct(\PDO $pdo, string $table, string $primaryKey)
    {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
    }

    
    private function query($sql, $parameters = [])
{
    $query = $this->pdo->prepare($sql);

    // Depuración: imprimir la consulta y los parámetros
    // echo "Query: " . $query->queryString . "\n";
    // echo "Parameters: " . json_encode($parameters) . "\n";

    // Vincular cada parámetro con su valor, con validación adicional
    foreach ($parameters as $name => $value) {
        
        // Verificar si el parámetro es la clave primaria y convertirlo a entero si es necesario
        if ($name === ':primaryKey') {
            if (!is_numeric($value)) {
                throw new \Exception("El parámetro 'primaryKey' debe ser numérico.");
            }
            $value = intval($value);
            var_dump($value);
        }

        // Determinar el tipo de dato del parámetro
        $type = \PDO::PARAM_STR;
        if (is_int($value)) {
            $type = \PDO::PARAM_INT;
        } elseif (is_bool($value)) {
            $type = \PDO::PARAM_BOOL;
        }

        // Vincular el parámetro
        $query->bindValue($name, $value, $type);
    }

    try {
        $query->execute();
    } catch (\PDOException $e) {
        // Manejo de excepciones más detallado
        echo "Error al ejecutar la consulta: " . $e->getMessage();
        // Registrar el error en un log, si es necesario
        error_log("Error en la base de datos: " . $e->getMessage());
        throw $e; // Re-lanzar la excepción para que pueda ser capturada en niveles superiores
    }

    return $query;
}

    public function total()
    {
        $query = $this->query('SELECT COUNT(*) FROM `' . $this->table . '`');
        $row = $query->fetch();
        return $row[0];
    }

    public function totalBy($field, $value)
    {
        $query = 'SELECT COUNT(*) AS `TotalBy` FROM `' . $this->table . '` WHERE `' . $field . '` = :value';

        $parameters = [
            'value' => $value
        ];

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($parameters);

        return $stmt->fetchColumn();
    }

    public function ultimoReg()
    {
        $sql = 'SELECT * FROM `' . $this->table . '` ORDER BY `' . $this->primaryKey . '` DESC LIMIT 1';
        $query = $this->query($sql);
        return $query->fetch();
    }

    public function findById($value)
    {
        $query = 'SELECT * FROM `' . $this->table . '` WHERE `' . $this->primaryKey . '` = :value';
        $parameters = [
            'value' => $value
        ];
        $query = $this->query($query, $parameters);
        return $query->fetch();
    }

    public function find($field, $value)
{
    $query = 'SELECT * FROM `' . $this->table . '` WHERE `' . $field . '` = :value';

    $values = [
        'value' => $value
    ];

    try {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($values);

        // Asegurar de que siempre se devuelve un array
        $result = $stmt->fetchAll();
        return $result ?: []; // Si $result es false, retorna un array vacío
    } catch (\PDOException $e) {
        // Manejo de errores opcional: puede registrar el error
        error_log('Error en find: ' . $e->getMessage());
        return []; // Devuelve un array vacío si ocurre algún error
    }
}


    public function findLast($field, $value)
    {
        $query = 'SELECT * FROM `' . $this->table . '` WHERE `' . $field . '` = :value ORDER BY `' . $this->primaryKey . '` DESC LIMIT 1';

        $values = [
            'value' => $value
        ];

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($values);

        return $stmt->fetch();
    }

    private function insert($fields)
    {
        if (empty($fields[$this->primaryKey])) {
            unset($fields[$this->primaryKey]);
        }

        $query = 'INSERT INTO `' . $this->table . '` (';
        $placeholders = [];
        $mappedFields = [];
        foreach ($fields as $key => $value) {
            $query .= '`' . $key . '`,';
            $placeholder = ':' . str_replace(
                ['ñ', 'á', 'é', 'í', 'ó', 'ú', 'ü', 'Ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ü'],
                ['n', 'a', 'e', 'i', 'o', 'u', 'u', 'N', 'A', 'E', 'I', 'O', 'U', 'U'],
                $key
            );
            $placeholders[] = $placeholder;
            $mappedFields[$placeholder] = $value;
        }
        $query = rtrim($query, ',') . ') VALUES (' . implode(',', $placeholders) . ')';

        $mappedFields = $this->processDates($mappedFields);
        //echo "Generated Query: " . $query . "\n";
        //echo "Mapped Fields: " . json_encode($mappedFields) . "\n";

        $this->query($query, $mappedFields);
    }



private function update($fields)
{
    $query = 'UPDATE `' . $this->table . '` SET ';
    $placeholders = [];
    foreach ($fields as $key => $value) {
        if ($key !== $this->primaryKey) {
            $placeholder = ':' . str_replace(
                ['ñ', 'á', 'é', 'í', 'ó', 'ú', 'ü', 'Ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ü'],
                ['n', 'a', 'e', 'i', 'o', 'u', 'u', 'N', 'A', 'E', 'I', 'O', 'U', 'U'],
                $key
            );
            $placeholders[] = '`' . $key . '` = ' . $placeholder;
        }
    }
    $query .= implode(', ', $placeholders);
    $query .= ' WHERE `' . $this->primaryKey . '` = :' . $this->primaryKey; // Asegúrate de que sea consistente

    // Procesar fechas
    $fields = $this->processDates($fields);

    // Mapear nombres de parámetros
    $mappedFields = [];
    foreach ($fields as $key => $value) {
        $placeholder = ':' . str_replace(
            ['ñ', 'á', 'é', 'í', 'ó', 'ú', 'ü', 'Ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ü'],
            ['n', 'a', 'e', 'i', 'o', 'u', 'u', 'N', 'A', 'E', 'I', 'O', 'U', 'U'],
            $key
        );
        $mappedFields[$placeholder] = $value;
    }

    // Asegúra de que el campo de la clave primaria esté correctamente asignado
    $mappedFields[':' . $this->primaryKey] = $fields[$this->primaryKey]; // Cambiado a usar la clave primaria

    // Depuración adicional
    //echo "Generated Query: " . $query . "\n";
    //echo "Mapped Fields: " . json_encode($mappedFields) . "\n";

    $this->query($query, $mappedFields);
}

    public function delete($id)
    {
        $parameters = [':id' => $id];
        $this->query('DELETE FROM `' . $this->table . '` WHERE `' . $this->primaryKey . '` = :id', $parameters);
    }

    public function findAll()
    {
        $result = $this->query('SELECT * FROM ' . $this->table);
        return $result->fetchAll();
    }

    private function processDates($fields)
    {
        foreach ($fields as $key => $value) {
            if ($value instanceof \DateTime) {
                $fields[$key] = $value->format('Y-m-d');
            }
        }
        return $fields;
    }

    public function save($record)
    {
        if (empty($record[$this->primaryKey])) {
            // Si el valor del primary key está vacío, asigna null para una inserción automática
            unset($record[$this->primaryKey]);
            $this->insert($record);
        } else {
            $existingRecord = $this->findById($record[$this->primaryKey]);
            if ($existingRecord) {
                $this->update($record);
            } else {
                $this->insert($record);
            }
        }
    }
}
