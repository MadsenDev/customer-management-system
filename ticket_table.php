echo '<table class="min-w-full bg-white mt-4">';
echo '<thead class="bg-gray-800 text-white">';
echo '<tr>';
echo '<th class="py-2 px-4 border-r">Ticket ID</th>';
echo '<th class="py-2 px-4 border-r">Status</th>';
echo '<th class="py-2 px-4">Description</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody class="text-gray-700">';
while ($row_tickets = $result_tickets->fetch_assoc()) {
    echo '<tr class="ticket-row" onclick="location.href=\'view_ticket.php?id=' . $row_tickets['TicketID'] . '\'">';
    echo '<td class="py-2 px-4">' . $row_tickets['TicketID'] . '</td>';
    echo '<td class="py-2 px-4">' . $row_tickets['StatusName'] . '</td>';
    echo '<td class="py-2 px-4">' . $row_tickets['Description'] . '</td>';
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';