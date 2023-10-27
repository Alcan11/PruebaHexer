<?php

class CarGateway
{
    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT *
                FROM coche";

        $stmt = $this->conn->query($sql);

        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $row["vendido"] = (bool) $row["vendido"];

            $data[] = $row;
        }

        return $data;
    }

    public function create(array $car): string
    {
        $sql = "INSERT INTO coche (marca, modelo, color, matricula, imagen, vendido) 
        VALUES (:marca, :modelo, :color, :matricula, :imagen, :vendido)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':marca', $car['marca']);
        $stmt->bindValue(':modelo', $car['modelo']);
        $stmt->bindValue(':color', $car['color']);
        $stmt->bindValue(':matricula', $car['matricula']);
        $stmt->bindValue(':imagen', $car['imagen']);
        $stmt->bindValue(':vendido', (bool) $car['vendido'] ?? false);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function get(string $id): array | false
    {
        $sql = "SELECT *
                FROM coche
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data !== false) {
            $data["vendido"] = (bool) $data["vendido"];
        }

        return $data;
    }

    public function update(array $current, array $new): int
    {
        if (isset($new['matricula'])) {
            $sql = "UPDATE coche SET matricula = :matricula WHERE coche.id = :id;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':matricula', $new['matricula']);
        } else {
            $sql = "UPDATE coche SET vendido = :vendido WHERE coche.id = :id;";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':vendido', $new['vendido']);
        }

        $stmt->bindValue(":id", $current["id"], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }

    public function delete(string $id): int
    {
        $sql = "DELETE FROM coche
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }
}
