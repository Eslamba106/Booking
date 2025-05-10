$(document).ready(function () {
    $('select[name=hotel_id]').on('change', function () {
        var hotel_id = $(this).val();
        if (hotel_id) {
            $.ajax({
                url: "{{ route('booking.get_country', ':id') }}".replace(':id', hotel_id),
                type: "GET",
                dataType: "json",
                success: function (response) {
                    $('select[name="country"]').empty();
                    $('input[name="city"]').val(response.city);
                    $('select[name="country"]').append('<option value="' + response.country.id + '">' + response.country.name + '</option>');
                }
            });
        }
    });

    $('#country_select').on('change', function () {
        var countryId = $(this).val();
        if (countryId) {
            $.ajax({
                url: '/get-cities/' + countryId,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#city_select').empty().append('<option value="">{{ __("select city") }}</option>');
                    $.each(data, function (key, value) {
                        $('#city_select').append('<option value="' + value.name + '">' + value.name + '</option>');
                    });
                }
            });
        } else {
            $('#city_select').empty().append('<option value="">{{ __("select city") }}</option>');
        }
    });
});