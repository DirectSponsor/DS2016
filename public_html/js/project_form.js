/**
 * This file is part of Organic Directory Application
 *
 * @copyright Copyright (c) 2016 McGarryIT
 * @link      (http://www.mcgarryit.com)
 */
$(document).ready(function(){
    $('#currency_conversion_factor').on('change', calculateDerivedAmounts);
    $('#min_euro_amount_per_recipient').on('change', calculateDerivedAmounts);
    $('#max_sponsors').on('change', calculateDerivedAmounts);
});


function calculateDerivedAmounts(evt) {
    var factor = $('#currency_conversion_factor').val();
    if (isNaN(factor)) {
        factor = 0;
    }
    $('#currency_conversion_factor').val(factor);

    var minEuroAmt = $('#min_euro_amount_per_recipient').val();
    if (isNaN(minEuroAmt)) {
        minEuroAmt = 0;
    }
    $('#min_euro_amount_per_recipient').val(minEuroAmt);

    var maxSponsors = parseInt($('#max_sponsors').val());
    if (isNaN(maxSponsors)) {
        maxSponsors = 0;
    }
    $('#max_sponsors').val(maxSponsors);

    $('#max_euro_amount_per_recipient').val(minEuroAmt * maxSponsors);

    $('#min_local_amount_per_recipient').val(minEuroAmt * factor);
    $('#max_local_amount_per_recipient').val($('#max_euro_amount_per_recipient').val() * factor);
}

