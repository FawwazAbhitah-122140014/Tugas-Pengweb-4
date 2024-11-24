const form = document.getElementById("registrationForm");

form.addEventListener("submit", function (e) {
    let isValid = true;

    // Validasi nama
    const name = document.getElementById("name").value;
    if (name.length < 3) {
        document.getElementById("errorName").innerText = "Nama minimal 3 karakter.";
        isValid = false;
    } else {
        document.getElementById("errorName").innerText = "";
    }

    // Validasi file
    const file = document.getElementById("file").files[0];
    if (file) {
        if (file.size > 1024 * 1024) { // 1MB
            document.getElementById("errorFile").innerText = "File tidak boleh lebih dari 1MB.";
            isValid = false;
        } else {
            document.getElementById("errorFile").innerText = "";
        }
    }

    if (!isValid) e.preventDefault();
});