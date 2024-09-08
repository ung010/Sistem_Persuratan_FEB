<script>
    function validateYearInput(input) {
        input.value = input.value.slice(0, 4);
        
        if (input.value > 2100) {
            input.value = 2100;
        }

        validateYears();
    }

    function validateYears() {
        const thnAwal = parseInt(document.getElementById('thn_awl').value, 10);
        const thnAkh = parseInt(document.getElementById('thn_akh').value, 10);

        if (!isNaN(thnAwal) && !isNaN(thnAkh)) {
            if (thnAwal > thnAkh) {
                document.getElementById('thn_akh').setCustomValidity('Tahun ajaran akhir harus lebih besar dari tahun ajaran awal.');
            } else {
                document.getElementById('thn_akh').setCustomValidity('');
            }
        } else {
            document.getElementById('thn_akh').setCustomValidity('');
        }
    }

    document.getElementById('thn_awl').addEventListener('input', function() {
        validateYearInput(this);
    });

    document.getElementById('thn_akh').addEventListener('input', function() {
        validateYearInput(this);
    });

    document.querySelector('form').addEventListener('submit', function(event) {
        validateYears();
        if (document.getElementById('thn_akh').validity.customError) {
            event.preventDefault();
        }
    });
</script>

<script>
    document.getElementById('ipk').addEventListener('input', function() {
        const ipk = parseFloat(this.value);
        if (ipk > 4.00) {
            this.value = 4.00;
        }
        if (this.value.includes('.') && this.value.split('.')[1].length > 2) {
            this.value = parseFloat(this.value).toFixed(2);
        }
    });

    document.getElementById('sksk').addEventListener('input', function() {
        let sksk = parseInt(this.value, 10);

        if (isNaN(sksk)) {
            this.value = '';
            return;
        }

        if (sksk < 1) {
            this.value = 1;
            return;
        }

        if (sksk > 170) {
            this.value = 170;
            return;
        }

        if (this.value.length > 3) {
            this.value = this.value.slice(0, 3);
        }
    });
</script>

<script>
    $(document).ready(function() {
        $('#asn').DataTable();
    });

    function addData() {
        $('#card-tambah').removeClass('d-none').addClass('d-block');
    }

    function resetData() {
        $('form :input').each(function() {
            if (!$(this).prop('readonly') && !$(this).is(':hidden')) {
                $(this).val('');
            }
        });
    }
</script>
