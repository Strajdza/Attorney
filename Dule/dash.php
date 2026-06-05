<?php
include "db.php"; // connect to your database

// Fetch all entries from the 'podatci' table
$sql = "SELECT * FROM podatci ORDER BY id DESC"; // latest first
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregled zahteva</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f4f4f4; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #333; color: #fff; }
        tr:nth-child(even) { background: #f9f9f9; }
        .container { max-width: 1200px; margin: auto; }
        .search { margin-bottom: 10px; padding: 5px; width: 300px; }
    </style>
    <script>
        // Simple search filter
        function searchTable() {
            let input = document.getElementById("searchInput").value.toLowerCase();
            let rows = document.querySelectorAll("table tbody tr");
            rows.forEach(row => {
                row.style.display = Array.from(row.cells).some(cell =>
                    cell.textContent.toLowerCase().includes(input)
                ) ? "" : "none";
            });
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Pregled pristiglih zahteva</h1>

        <input type="text" id="searchInput" class="search" onkeyup="searchTable()" placeholder="Pretraži po imenu, e-mailu, telefonu...">

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ime</th>
                    <th>Prezime</th>
                    <th>Email</th>
                    <th>Telefon</th>
                    <th>Zahtev</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['ID'] ?></td>
                            <td><?= htmlspecialchars($row['Ime']) ?></td>
                            <td><?= htmlspecialchars($row['Prezime']) ?></td>
                            <td><?= htmlspecialchars($row['Email']) ?></td>
                            <td><?= htmlspecialchars($row['Telefon']) ?></td>
                            <td><?= htmlspecialchars($row['Zahtev']) ?></td>
                            
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">Nema podataka</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>