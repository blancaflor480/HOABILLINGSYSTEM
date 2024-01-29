<script>
 $(document).ready(function () {
    // Initialize DataTable
    $('#list').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [5, 10, 25, 50, 75, 100],
        "pageLength": 10,
        "order": [[1, 'desc']],
    });

    // Handle click event for "View" button
    $('#list').on('click', '.view-bill', function () {
        var tableusers_id = $(this).data('user-id');
        
        console.log('Fetching details for tableusers_id:', tableusers_id);
        // Make an AJAX request to fetch bill details for the selected user
        $.ajax({
            url: 'fetch_bill_details.php',
            method: 'GET',
            data: { tableusers_id: tableusers_id },
            success: function (response) {
                try {
                    // Parse the JSON response
                    var data = JSON.parse(response);

                    // Check if there is an error
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    // Update the modal content with the fetched bill details
                    $('#viewbills .modal-body #name').val(data.tableusers_id);
                    $('#viewbills .modal-body #readingDueDate').val(data.reading_date);
                    $('#viewbills .modal-body #duedate').val(data.due_date);
                    $('#viewbills .modal-body #current').val(data.reading);
                    $('#viewbills .modal-body #previousBalance').val(data.previous);
                    $('#viewbills .modal-body #service').val(data.service);
                    $('#viewbills .modal-body #penalties').val(data.penalties);
                    $('#viewbills .modal-body #total').val(data.total);
                    $('#viewbills .modal-body #status').val(data.status);

                    // Show the modal
                    $('#viewbills').modal('show');
                } catch (error) {
                    console.error('Error parsing JSON response:', error);
                }
            },
            error: function () {
                // Handle errors if any
                alert('Error fetching bill details.');
            }
        });
    });

    $(document).ready(function () {
    $('#list').on('click', '.update-bill', function () {
        var tableusers_id = $(this).closest('tr').find('td:nth-child(2)').text();
        console.log('Updating details for tableusers_id:', tableusers_id);

        $.ajax({
            url: 'fetch_bill_details.php',
            method: 'GET',
            data: { tableusers_id: tableusers_id },
            success: function (response) {
                console.log('Server Response:', response);

                try {
                    var data = JSON.parse(response);
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    $('#editbills .modal-body #name').val(data.tableusers_id);
                    $('#editbills .modal-body #readingDueDate').val(data.reading_date);
                    $('#editbills .modal-body #duedate').val(data.due_date);
                    $('#editbills .modal-body #current').val(data.reading);
                    $('#editbills .modal-body #previousBalance').val(data.previous);
                    $('#editbills .modal-body #service').val(data.service);
                    $('#editbills .modal-body #penalties').val(data.penalties);
                    $('#editbills .modal-body #total').val(data.total);
                    $('#editbills .modal-body #status').val(data.status);

                    $('#editbills').modal('show');
                } catch (error) {
                    console.error('Error parsing JSON response:', error);
                }
            },
            error: function () {
                alert('Error fetching bill details.');
            }
        });
    });
  });
});
</script>
<script>
        $(document).ready(function () {

            $('.update-bill').on('click', function () {

                $('#editbills').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#tableusers_id').val(data[0]);
                $('#readingDueDate').val(data[1]);
                $('#duedate').val(data[2]);
                $('#current').val(data[3]);
                $('#previousBalance').val(data[4]);
                $('#service').val(data[5]);
                $('#penalties').val(data[6]);
                $('#total').val(data[7]);
            });
        });
    </script>
