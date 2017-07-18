/**
 * Created by genjerator on 16.7.17..
 */

$(document).ready(function () {
    $('input').keydown(function (event) {

        if (event.keyCode == 13) {
            /* FOCUS ELEMENT */
            var inputs = $(this).parents("form").eq(0).find(":input");
            var idx = inputs.index(this);

            if (idx == inputs.length - 1) {
                inputs[0].select()
            } else {
                inputs[idx + 1].focus(); //  handles submit buttons
                inputs[idx + 1].select();
            }
            return false;
        }
    });

    $( 'form[name="numa_doadmsbundle_billing"]').submit(function() {
        calculate();
        return true; // return false to cancel form action
    });
    calculate();
});

$('.col-md-10').change(function () {
    calculate()
});

function calculate() {
    console.log("calculating");

    var n1 = parseFloat(document.getElementById("numa_doadmsbundle_billing_sale_price").value);
    var n2 = parseFloat(document.getElementById("numa_doadmsbundle_billing_admin_fee").value);
    var n3 = parseFloat(document.getElementById("numa_doadmsbundle_billing_warranty").value);
    var n4 = parseFloat(document.getElementById("numa_doadmsbundle_billing_protection_pkg").value);

    var n5 = parseFloat(document.getElementById("numa_doadmsbundle_billing_less_trade_in").value);

    var n6 = parseFloat(document.getElementById("numa_doadmsbundle_billing_tax1").value);
    var n7 = parseFloat(document.getElementById("numa_doadmsbundle_billing_tax2").value);
    var n77 = parseFloat(document.getElementById("numa_doadmsbundle_billing_tax3").value);

    var n8 = parseFloat(document.getElementById("numa_doadmsbundle_billing_other_misc1").value);
    var n9 = parseFloat(document.getElementById("numa_doadmsbundle_billing_other_misc2").value);

    var n10 = parseFloat(document.getElementById("numa_doadmsbundle_billing_lien_on_trade_in").value);

    var n11 = parseFloat(document.getElementById("numa_doadmsbundle_billing_less_trade_in_tax").value);
    var n12 = parseFloat(document.getElementById("numa_doadmsbundle_billing_less_deposit").value);

    var n13 = parseFloat(document.getElementById("numa_doadmsbundle_billing_balance_to_finance").value);
    var n14 = parseFloat(document.getElementById("numa_doadmsbundle_billing_life_insurance").value);
    var n15 = parseFloat(document.getElementById("numa_doadmsbundle_billing_disability_insurance").value);
    //var n16 = parseFloat(document.getElementById("numa_doadmsbundle_billing_bank_registration_fee").value);

    if (isNaN(parseFloat(n1))) {
        n1 = 0;
    }
    if (isNaN(parseFloat(n2))) {
        n2 = 0;
    }
    if (isNaN(parseFloat(n3))) {
        n3 = 0;
    }
    if (isNaN(parseFloat(n4))) {
        n4 = 0;
    }
    if (isNaN(parseFloat(n5))) {
        n5 = 0;
    }
    if (isNaN(parseFloat(n6))) {
        n6 = 0;
    }
    if (isNaN(parseFloat(n7))) {
        n7 = 0;
    }
    if (isNaN(parseFloat(n77))) {
        n77 = 0;
    }
    if (isNaN(parseFloat(n8))) {
        n8 = 0;
    }
    if (isNaN(parseFloat(n9))) {
        n9 = 0;
    }
    if (isNaN(parseFloat(n10))) {
        n10 = 0;
    }
    if (isNaN(parseFloat(n11))) {
        n11 = 0;
    }
    if (isNaN(parseFloat(n12))) {
        n12 = 0;
    }
    if (isNaN(parseFloat(n13))) {
        n13 = 0;
    }
    if (isNaN(parseFloat(n14))) {
        n14 = 0;
    }

    if (isNaN(parseFloat(n15))) {
        n15 = 0;
    }

//            if (isNaN(parseFloat(n16))) {
//                n16 = 0;
//            }

    var res1 = n1 + n2 + n3 + n4;
    var res2 = res1 - n5 + (n6 + n7 + n77) + n8 + n9 + n10;
    n8 = parseFloat((res1 * 0.06).toFixed(2));
    n9 = parseFloat((res1 * 0.05).toFixed(2));
    $("#numa_doadmsbundle_billing_other_misc1").val(n8);
    $("#numa_doadmsbundle_billing_other_misc2").val(n9);
    $('#numa_doadmsbundle_billing_tos_total').val(res1);
    $('#numa_doadmsbundle_billing_difference_payable').val(res1 - n5);
    $('#numa_doadmsbundle_billing_taxes_paid_total').val(parseFloat(n8 + n9));
    console.log(n8);
    console.log(n9);
    console.log(parseFloat(n8+n9));
    console.log($('#numa_doadmsbundle_billing_taxes_paid_total').val());
    $('#numa_doadmsbundle_billing_total_due').val(res2);
    $('#numa_doadmsbundle_billing_payable_on_delivery').val(res2 - (n11 + n12));
    $('#numa_doadmsbundle_billing_total_balance_due').val(((res2 - (n11 + n12)) - n13) + (n14 + n15));// + n16
};
