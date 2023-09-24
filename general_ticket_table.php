<!-- general_ticket_table.php -->
<table class="min-w-full bg-white">
    <thead>
        <tr>
            <th class="py-2 px-4 border"><a href="?order=TicketID">Ticket ID</a></th>
            <th class="py-2 px-4 border"><a href="?order=CustomerID">Customer</a></th>
            <th class="py-2 px-4 border"><a href="?order=StatusID">Status</a></th>
            <th class="py-2 px-4 border"><a href="?order=CreatedBy">Created By</a></th>
            <th class="py-2 px-4 border"><a href="?order=Description">Description</a></th>
            <th class="py-2 px-4 border"><a href="?order=CreatedAt">Created At</a></th>
            <th class="py-2 px-4 border"><a href="?order=UpdatedAt">Updated At</a></th>
            <th class="py-2 px-4 border">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td class="py-2 px-4 border"><?= $row["TicketID"] ?></td>
                <td class="py-2 px-4 border"><?= $row["CFirstName"] . ' ' . $row["CLastName"] ?></td>
                <td class="py-2 px-4 border"><?= $row["StatusName"] ?></td>
                <td class="py-2 px-4 border"><?= $row["UFirstName"] . ' ' . $row["ULastName"] ?></td>
                <td class="py-2 px-4 border"><?= $row["Description"] ?></td>
                <td class="py-2 px-4 border"><?= $row["CreatedAt"] ?></td>
                <td class="py-2 px-4 border"><?= $row["UpdatedAt"] ?></td>
                <td class="py-2 px-4 border">
                    <a href="view_ticket.php?id=<?= $row['TicketID'] ?>">View</a> |
                    <a href="edit_ticket.php?id=<?= $row['TicketID'] ?>">Edit</a> |
                    <a href="delete_ticket.php?id=<?= $row['TicketID'] ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>