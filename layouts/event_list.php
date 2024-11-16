<!-- Search and Filter Form -->
<div class="row mb-3">
    <div class="form-group col-sm-6">
        <input type="text" id="search_input" class="form-control" placeholder="Search by Event Name">
    </div>
    <div class="form-group col-sm-6">
        <select class="form-control" id="event_type_filter">
            <option value="">All Event Types</option>
            <option value="Conference">Conference</option>
            <option value="Workshop">Workshop</option>
            <option value="Seminar">Seminar</option>
            <option value="Webinar">Webinar</option>
        </select>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-bordered" id="event_table">
        <thead>
            <tr>
                <th>Event ID</th>
                <th>Event Name</th>
                <th>Event Type</th>
                <th>Event Location</th>
                <th>Event Organizer</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (file_exists($filename)): ?>
                <?php $file = fopen($filename, 'r'); ?>
                <?php while (($line = fgets($file)) !== false): ?>
                    <?php $data = explode('|', trim($line)); ?>
                    <tr class="event-row" data-event-type="<?= strtolower($data[6]) ?>" data-event-name="<?= strtolower($data[1]) ?>">
                        <td><?= $data[0] ?></td>
                        <td><?= $data[1] ?></td>
                        <td><?= $data[6] ?></td>
                        <td><?= $data[3] ?></td>
                        <td><?= $data[7] ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="detail.php?id=<?= $data[0] ?>">Detail</a>
                            <?php if ($data[12] == 0): ?>
                                <a class="btn btn-success btn-sm" href="publish.php?id=<?= $data[0] ?>&on=1">Publish</a>
                            <?php else: ?>
                                <a class="btn btn-danger btn-sm" href="publish.php?id=<?= $data[0] ?>&off=0">Unpublish</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <?php fclose($file); ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    // JavaScript for search and filter
    const searchInput = document.getElementById('search_input');
    const eventTypeFilter = document.getElementById('event_type_filter');

    // Function to filter rows based on search and event type
    function filterRows() {
        const searchText = searchInput.value.toLowerCase();
        const selectedType = eventTypeFilter.value.toLowerCase();
        const rows = document.querySelectorAll('.event-row');

        rows.forEach(row => {
            const eventName = row.getAttribute('data-event-name');
            const eventType = row.getAttribute('data-event-type');

            // Check if the row matches the search text and selected event type
            const matchesSearch = eventName.includes(searchText);
            const matchesType = selectedType === "" || eventType === selectedType;

            // Show the row if both conditions are satisfied, otherwise hide it
            if (matchesSearch && matchesType) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Attach event listeners for real-time filtering
    searchInput.addEventListener('input', filterRows);
    eventTypeFilter.addEventListener('change', filterRows);
</script>
