$(document).ready(function () {
    UnInvoiceTransaction();

    setInterval(UnInvoiceTransaction, 300000); // 300000ms = 5 minutes
});

/* 🔍 Verify Government Corp customers with approved quotes but no invoice */
function UnInvoiceTransaction() {
    $.post("dirs/auditchecker/actions/get_auditchecker.php", {}, function (data) {
        try {
            let response = JSON.parse(data);

            if ($.trim(response.isSuccess) === "success") {
                // Optionally show result in console for debugging
                console.log("✅ Audit check passed:", response.Data || "No missing invoices found");
            } else {
                console.warn("⚠️ Audit issue:", $.trim(response.Data));
            }
        } catch (err) {
            console.error("❌ Invalid JSON response from server:", data, err);
        }
    }).fail(function (xhr, status, error) {
        console.error("❌ Request failed:", status, error);
    });
}
