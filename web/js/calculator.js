/**
 * Created by vladimir on 9.2.17..
 */
function IsEmpty(a) {
    return a.value.length == 0
}

function doLoanValidationControl() {
    if (doFieldValidation(document.getElementById("SalesPriceLoan"), false)) {
        salesPriceLoan = parseFloat(document.getElementById("SalesPriceLoan").value.replace(/,/gi, ""))
    } else {
        return false
    }
    if (doFieldValidation(document.getElementById("SalesTaxLoan"), true)) {
        salesTaxLoan = parseFloat(document.getElementById("SalesTaxLoan").value.replace(/,/gi, ""))
    } else {
        if (IsEmpty(document.getElementById("SalesTaxLoan"))) {
            salesTaxLoan = 0
        } else {
            return false
        }
    }
    if (doFieldValidation(document.getElementById("TermLoan"), false)) {
        loanTermLoan = parseFloat(document.getElementById("TermLoan").value.replace(/,/gi, ""))
    } else {
        return false
    }
    if (doFieldValidation(document.getElementById("InterestRateLoan"), false)) {
        interestRateLoan = parseFloat(document.getElementById("InterestRateLoan").value.replace(/,/gi, ""))
    } else {
        return false
    }
    if (doFieldValidation(document.getElementById("CashTradeLoan"), true)) {
        tradeInValueLoan = parseFloat(document.getElementById("CashTradeLoan").value.replace(/,/gi, ""))
    } else {
        if (IsEmpty(document.getElementById("CashTradeLoan"))) {
            tradeInValueLoan = 0
        } else {
            return false
        }
    }
    return true
}
function doLeaseValidationControl() {
    if (doFieldValidation(document.getElementById("SalesPriceLease"), false)) {
        salesPriceLease = parseFloat(document.getElementById("SalesPriceLease").value.replace(/,/gi, ""))
    } else {
        return false
    }
    if (doFieldValidation(document.getElementById("SalesTaxLease"), true)) {
        salesTaxLease = parseFloat(document.getElementById("SalesTaxLease").value.replace(/,/gi, ""))
    } else {
        if (IsEmpty(document.getElementById("SalesTaxLease"))) {
            salesTaxLease = 0
        } else {
            return false
        }
    }
    if (doFieldValidation(document.getElementById("TermLease"), false)) {
        loanTermLease = parseFloat(document.getElementById("TermLease").value.replace(/,/gi, ""))
    } else {
        return false
    }
    if (doFieldValidation(document.getElementById("InterestRateLease"), false)) {
        interestRateLease = parseFloat(document.getElementById("InterestRateLease").value.replace(/,/gi, ""))
    }
    if (doFieldValidation(document.getElementById("ResidualLease"), false)) {
        residualValueLease = parseFloat(document.getElementById("ResidualLease").value.replace(/,/gi, ""))
    } else {
        return false
    }
    if (doFieldValidation(document.getElementById("CashTradeLease"), true)) {
        tradeInValueLease = parseFloat(document.getElementById("CashTradeLease").value.replace(/,/gi, ""))
    } else {
        if (IsEmpty(document.getElementById("CashTradeLease"))) {
            tradeInValueLease = 0
        } else {
            return false
        }
    }
    return true
}
function CalculateLoan(a) {
    salesPriceLoan = 0;
    salesTaxLoan = 0;
    loanTermLoan = 0;
    interestRateLoan = 0;
    downPaymentLoan = 0;
    tradeInValueLoan = 0;
    rebatesLoan = 0;
    var b = document.getElementById("loan" + a);
    var d = document.getElementById("loanAmount" + a);
    var e = document.getElementById("loanAmountWarning" + a);
    e.style.display = "none";
    if (doLoanValidation(a)) {
        interestRateLoan = interestRateLoan / 100;
        interestRateLoan = interestRateLoan / 12;
        salesTaxLoan = salesTaxLoan / 100;
        var f = (salesPriceLoan * (1 + salesTaxLoan)) - downPaymentLoan - tradeInValueLoan - rebatesLoan;
        var g = 0;
        if (Number(interestRateLoan) == 0) {
            g = f / loanTermLoan
        } else {
            g = f * (interestRateLoan * Math.pow(1 + interestRateLoan, loanTermLoan)) / (Math.pow(1 + interestRateLoan, loanTermLoan) - 1)
        }
        if (g < 0 || isNaN(g)) {
            g = 0
        }
        b.innerHTML = g.toFixed(2);
        d.style.display = "";
        e.style.display = "none"
    } else {
        d.style.display = "none";
        e.style.display = ""
    }
}
function CalculateLease(d) {
    salesPriceLease = 0;
    salesTaxLease = 0;
    loanTermLease = 0;
    interestRateLease = 0;
    residualValueLease = 0;
    downPaymentLease = 0;
    tradeInValueLease = 0;
    rebatesLease = 0;
    var e = document.getElementById("lease" + d);
    var f = document.getElementById("leaseAmount" + d);
    var g = document.getElementById("leaseAmountWarning" + d);
    g.style.display = "none";
    if (doLeaseValidation(d)) {
        if (salesTaxLease >= 1) {
            salesTaxLease = salesTaxLease / 100
        }
        var b = salesPriceLease - downPaymentLease - tradeInValueLease - rebatesLease;
        var j = b - residualValueLease;
        var a = 0;
        if (loanTermLease >= 1) {
            a = j / loanTermLease
        }
        a = Math.round(a * 100) / 100;
        var k = interestRateLease / 2400;
        k = Math.round(k * 100000) / 100000;
        var h = (b + residualValueLease) * k + a;
        h = Math.round(h * 100) / 100;
        h = h + h * salesTaxLease;
        if (h < 0 || isNaN(h)) {
            h = 0
        }
        e.innerHTML = h.toFixed(2);
        f.style.display = "";
        g.style.display = "none"
    } else {
        f.style.display = "none";
        g.style.display = ""
    }
}
function doCalculation(a) {
    if (document.getElementById("loan" + a)) {
        CalculateLoan(a)
    }
    if (document.getElementById("lease" + a)) {
        CalculateLease(a)
    }
}
function doLeaseValidation(a) {
    if (doFieldValidation(document.getElementById("_txtSalesPriceLease" + a), false)) {
        salesPriceLease = parseFloat(document.getElementById("_txtSalesPriceLease" + a).value)
    } else {
        return false
    }
    if (doFieldValidation(document.getElementById("_txtSalesTaxLease" + a), true)) {
        salesTaxLease = parseFloat(document.getElementById("_txtSalesTaxLease" + a).value)
    } else {
        if (IsEmpty(document.getElementById("_txtSalesTaxLease" + a))) {
            salesTaxLease = 0
        } else {
            return false
        }
    }
    if (doFieldValidation(document.getElementById("_txtTermLease" + a), false)) {
        loanTermLease = parseFloat(document.getElementById("_txtTermLease" + a).value)
    } else {
        return false
    }
    if (doFieldValidation(document.getElementById("_txtInterestRateLease" + a), false)) {
        interestRateLease = parseFloat(document.getElementById("_txtInterestRateLease" + a).value)
    } else {
        return false
    }
    if (doFieldValidation(document.getElementById("_txtResidualValueLease" + a), false)) {
        residualValueLease = parseFloat(document.getElementById("_txtResidualValueLease" + a).value)
    } else {
        return false
    }
    if (doFieldValidation(document.getElementById("_txtDownPaymentLease" + a), true)) {
        downPaymentLease = parseFloat(document.getElementById("_txtDownPaymentLease" + a).value)
    } else {
        if (IsEmpty(document.getElementById("_txtDownPaymentLease" + a))) {
            downPaymentLease = 0
        } else {
            return false
        }
    }
    if (doFieldValidation(document.getElementById("_txtTradeInValueLease" + a), true)) {
        tradeInValueLease = parseFloat(document.getElementById("_txtTradeInValueLease" + a).value)
    } else {
        if (IsEmpty(document.getElementById("_txtTradeInValueLease" + a))) {
            tradeInValueLease = 0
        } else {
            return false
        }
    }
    if (doFieldValidation(document.getElementById("_txtRebatesLease" + a), true)) {
        rebatesLease = parseFloat(document.getElementById("_txtRebatesLease" + a).value)
    } else {
        if (IsEmpty(document.getElementById("_txtRebatesLease" + a))) {
            rebatesLease = 0
        } else {
            return false
        }
    }
    return true
}
function doLoanValidation(a) {
    if (doFieldValidation(document.getElementById("_txtSalesPriceLoan" + a), false)) {
        salesPriceLoan = parseFloat(document.getElementById("_txtSalesPriceLoan" + a).value)
    } else {
        return false
    }
    if (doFieldValidation(document.getElementById("_txtSalesTaxLoan" + a), true)) {
        salesTaxLoan = parseFloat(document.getElementById("_txtSalesTaxLoan" + a).value)
    } else {
        if (IsEmpty(document.getElementById("_txtSalesTaxLoan" + a))) {
            salesTaxLoan = 0
        } else {
            return false
        }
    }
    if (doFieldValidation(document.getElementById("_txtTermLoan" + a), false)) {
        loanTermLoan = parseFloat(document.getElementById("_txtTermLoan" + a).value)
    } else {
        return false
    }
    if (doFieldValidation(document.getElementById("_txtInterestRateLoan" + a), false)) {
        interestRateLoan = parseFloat(document.getElementById("_txtInterestRateLoan" + a).value)
    } else {
        return false
    }
    if (doFieldValidation(document.getElementById("_txtDownPaymentLoan" + a), true)) {
        downPaymentLoan = parseFloat(document.getElementById("_txtDownPaymentLoan" + a).value)
    } else {
        if (IsEmpty(document.getElementById("_txtDownPaymentLoan" + a))) {
            downPaymentLoan = 0
        } else {
            return false
        }
    }
    if (doFieldValidation(document.getElementById("_txtTradeInValueLoan" + a), true)) {
        tradeInValueLoan = parseFloat(document.getElementById("_txtTradeInValueLoan" + a).value)
    } else {
        if (IsEmpty(document.getElementById("_txtTradeInValueLoan" + a))) {
            tradeInValueLoan = 0
        } else {
            return false
        }
    }
    if (doFieldValidation(document.getElementById("_txtRebatesLoan" + a), true)) {
        rebatesLoan = parseFloat(document.getElementById("_txtRebatesLoan" + a).value)
    } else {
        if (IsEmpty(document.getElementById("_txtRebatesLoan" + a))) {
            rebatesLoan = 0
        } else {
            return false
        }
    }
    return true
}
function doFieldValidation(a, b) {
    var d = "";
    if (!b && IsEmpty(a)) {
        select(a);
        return false
    } else {
        if (b && IsEmpty(a)) {
            return false
        }
    }
    d = parseFloat(a.value, 10);
    if (isNaN(d) || (d != a.value)) {
//                alert(a.name + " must be a number.");
        select(a);
        return false
    }
    return true
}
function select(a) {
    a.focus();
    a.select()
}
function SwitchToLease(b) {
    var a = document.getElementById("_loanCalculator" + b);
    a.style.display = "none";
    a = document.getElementById("_leaseCalculator" + b);
    a.style.display = "block"
}
function SwitchToLoan(b) {
    var a = document.getElementById("_loanCalculator" + b);
    a.style.display = "block";
    a = document.getElementById("_leaseCalculator" + b);
    a.style.display = "none"
}
PaymentCalculator();
function PaymentCalculator() {
    var a = document.getElementById("desiredPrice");
    var j = document.getElementById("salesTax1");
    var k = document.getElementById("term1");
    var f = document.getElementById("rate1");
    var b = document.getElementById("downPayment1");
    var g = "$";
    var e = f.value.replace(/%/gi, "");
    var h = j.value.replace(/%/gi, "");
    if (doFieldValidation(a, false) && doFieldValidation2(j, true, j) && doFieldValidation(k, false) && doFieldValidation2(f, false, f) && doFieldValidation(b, true)) {
        if (e > 0) {
            var l = e / 100 / 12;
            var m = h / 100;
            var d = (a.value * (1 + m)) - b.value;
            if (k.value > 0) {
                g = d * (l * Math.pow(1 + l, k.value)) / (Math.pow(1 + l, k.value) - 1)
            } else {
                g = 0
            }
        } else {
            var m = h / 100;
            if (k.value > 0) {
                g = (a.value * (1 + m) - b.value) / k.value
            } else {
                g = 0
            }
        }
    }
    if (g == "$" || g < 0 || isNaN(g)) {
        $("#monthlyPayment").html("$0.00")
    } else {
        $("#monthlyPayment").html("$" + NumericDGroup(g.toFixed(2)))
    }
}
AffordabilityCalculator();
function AffordabilityCalculator() {
    var a = document.getElementById("desiredPayment");
    var h = document.getElementById("salesTax2");
    var j = document.getElementById("term2");
    var e = document.getElementById("rate2");
    var b = document.getElementById("downPayment2");
    var f = "$";
    var d = e.value.replace(/%/gi, "");
    var g = h.value.replace(/%/gi, "");
    if (doFieldValidation(a, false) && doFieldValidation2(h, true, h) && doFieldValidation(j, false) && doFieldValidation2(e, false, e) && doFieldValidation(b, true)) {
        if (d > 0) {
            var k = d / 100 / 12;
            var l = g / 100;
            f = ((a.value * (Math.pow(1 + k, j.value) - 1)) / (k * Math.pow(1 + k, j.value)) / (1 + l)) + b.value * 1
        } else {
            var l = g / 100;
            f = ((a.value * j.value) / (1 + l)) + b.value * 1
        }
    }
    if (f == "$" || f < 0 || isNaN(f)) {
        $("#estimatedPrice").html("$0.00")
    } else {
        $("#estimatedPrice").html("$" + NumericDGroup(f.toFixed(2)))
    }
}
function doFieldValidation2(a, e, b) {
    var d = "";
    if (!e && IsEmpty(a)) {
        select(b);
        return false
    } else {
        if (e && IsEmpty(a)) {
            return false
        }
    }
    d = parseFloat(a.value.replace(/%/gi, "").replace(/,/gi, ""), 10);
    if (isNaN(d) || (d != a.value.replace(/%/gi, "").replace(/,/gi, ""))) {
//                alert(b.name + " must be a number.");
        select(b);
        return false
    }
    return true
}
function NumericDGroup(a) {
    var e = "";
    var d = "";
    var b = a.indexOf(".");
    if (b < 0) {
        b = a.length
    } else {
        d = a.substring(b, a.length)
    }
    for (i = b; i > 0; i = i - 3) {
        if (i < 4) {
            e = a.slice(0, i);
            d = e + d
        } else {
            e = a.slice(i - 3, i);
            d = "," + e + d
        }
    }
    return d
}
function SearchCarsFromCalculator(a, b, e) {
    var d = "";
    if (b) {
        d = $("#" + a).html();
        d = d.substring(1, d.length - 3);
        d = d.replace(",", "")
    } else {
        d = $("#" + a).val()
    }
    if (b && d == 0) {
        alert("Please provide your Desired Monthly Payment in order to continue your search.")
    } else {
        if (!b && d == "") {
            alert("Please provide your Desired Vehicle Price in order to continue your search.")
        } else {
            e = e.replace("{price}", d);
            window.location = e
        }
    }
}
function AddPercentToNumeric(a) {
    if (a.value.indexOf("%") == a.value.length - 1) {
        a.value = a.value.substr(0, a.value.length - 1)
    } else {
        a.value = a.value + "%"
    }
}
function CalculatorClearField(b, a) {
    if (b.value == a) {
        b.value = ""
    }
}
function CalculatorPopulateField(b, a) {
    if (b.value.length == 0) {
        b.value = a
    }
}