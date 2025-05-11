$(document).ready(function() {
    $('select[name=hotel_id]').on('change', function() {
        var hotel_id = $(this).val();
        if (hotel_id) {
            $.ajax({
                url: "{{ route('booking.get_country', ':id') }}".replace(':id', hotel_id),
                type: "GET",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    $('select[name="country"]').empty();
                    $('input[name="city"]').empty();
                    // console.log(response.city);
                    $('input[name="city"]').val(response.city);
                    $('select[name="country"]').append('<option value="' + response
                        .country.id +
                        '">' + response.country.name + '</option>');
                },
                error: function(xhr, status, error) {
                    console.error("Error occurred:", error);

                }
            });
        }
    });
})
