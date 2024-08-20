    <script>
        $(document).ready(function() {
            $('#asn').DataTable();
        });

        function addData() {
            $('#card-tambah').removeClass('d-none').addClass('d-block');
        }

        function resetData() {
            $('form :input').each(function() {
                // Check if the field is neither readonly nor hidden
                if (!$(this).prop('readonly') && !$(this).is(':hidden')) {
                    // Reset the value of the field
                    $(this).val('');
                }
            });
        }
    </script>