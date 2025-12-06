/* =========================================================
   FILE  : assets/js/script.js
   AUTHOR: E-Learning Project
   DESC  : Javascript umum untuk seluruh halaman
========================================================= */


/* Fade-out alert (jika ada elemen .alert di halaman) */
document.addEventListener("DOMContentLoaded", () => {
    const alerts = document.querySelectorAll(".alert");

    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 600);
        }, 3000);
    });
});


/* Toggle show/hide password (otomatis bekerja bila ada input password) */
const passFields = document.querySelectorAll('input[type="password"]');

passFields.forEach(field => {
    const toggle = document.createElement("span");
    toggle.textContent = "👁";
    toggle.style.cursor = "pointer";
    toggle.style.userSelect = "none";
    toggle.style.marginLeft = "6px";
    toggle.style.fontSize = "14px";

    field.insertAdjacentElement("afterend", toggle);

    toggle.addEventListener("click", () => {
        field.type = field.type === "password" ? "text" : "password";
    });
});


/* Validasi form (login & register) */
const forms = document.querySelectorAll("form");

forms.forEach(form => {
    form.addEventListener("submit", e => {
        let valid = true;
        const inputs = form.querySelectorAll("input[required], textarea[required]");

        inputs.forEach(input => {
            if (input.value.trim() === "") {
                valid = false;
                input.style.border = "1px solid red";
            } else {
                input.style.border = "1px solid #d1d5db";
            }
        });

        if (!valid) {
            e.preventDefault();
            alert("Harap isi semua form dengan lengkap!");
        }
    });
});


/* Konfirmasi saat ingin menghapus / logout */
window.confirmDelete = (url) => {
    if (confirm("Yakin ingin menghapus data ini?")) {
        window.location = url;
    }
};

window.confirmLogout = (url) => {
    if (confirm("Logout sekarang?")) {
        window.location = url;
    }
};
