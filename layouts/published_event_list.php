<div class="row mb-3">
    <div class="col-sm-6">
        <!-- Search by Event Name -->
        <input type="text" id="search_event_name" class="form-control" placeholder="Search by Event Name">
    </div>
    <div class="col-sm-6">
        <!-- Filter by Event Type -->
        <select class="form-control" id="filter_event_type" name="filter_event_type">
            <option value="">All Types</option>
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
                <th>Event Location in Map</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (file_exists($filename)): ?>
                <?php $file = fopen($filename, 'r'); ?>
                <?php while (($line = fgets($file)) !== false): ?>
                    <?php
                    $data = explode('|', trim($line));
                    $publish = end($data);

                    // Display the row only if publish == 1
                    if ($publish == '1'):
                    ?>
                        <tr class="event-row" data-event-type="<?= $data[6] ?>" data-event-name="<?= strtolower($data[1]) ?>">
                            <td><?= $data[0] ?></td>
                            <td><?= $data[1] ?></td>
                            <td><?= $data[6] ?></td>
                            <td><?= $data[3] ?></td>
                            <td><?= $data[7] ?></td>
                            <td>
                                <a href='view_location.php?lat=<?= $data[10] ?>&lng=<?= $data[11] ?>&name=<?= $data[1] ?>' target='_blank' class='btn btn-sm btn-info'>View Location</a>
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="detail.php?id=<?= $data[0] ?>">Detail</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endwhile; ?>
                <?php fclose($file); ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    // JavaScript to filter by event name and event type
    const searchInput = document.getElementById('search_event_name');
    const filterDropdown = document.getElementById('filter_event_type');

    function filterEvents() {
        const searchText = searchInput.value.toLowerCase();
        const selectedType = filterDropdown.value.toLowerCase();
        const rows = document.querySelectorAll('.event-row');

        rows.forEach(row => {
            const eventName = row.getAttribute('data-event-name').toLowerCase();
            const eventType = row.getAttribute('data-event-type').toLowerCase();

            // Check if the row matches the search text and selected type
            const matchesSearch = eventName.includes(searchText);
            const matchesType = selectedType === "" || eventType === selectedType;

            // Show or hide the row based on the filters
            if (matchesSearch && matchesType) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Attach event listeners for search input and filter dropdown
    searchInput.addEventListener('input', filterEvents);
    filterDropdown.addEventListener('change', filterEvents);
</script>
