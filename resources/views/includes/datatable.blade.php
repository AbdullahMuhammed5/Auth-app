<script type="text/javascript">
    $(function () {
        if($('.data-table').length > 0  ) {
            let table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route(Request::segments()[0].'.index') }}",
                columns: JSON.parse(@json($columns ?? "default")),
                dom: 'lfrtipB',
                buttons: [
                    'copy', 'excel', 'pdf'
                ],
                responsive: true
            });
        }
    });
</script>
