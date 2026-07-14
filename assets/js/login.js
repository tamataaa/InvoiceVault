const togglePassword = document.getElementById("togglePassword");
const password = document.getElementById("password");
const icon = document.getElementById("toggleIcon");

if (togglePassword) {

    togglePassword.addEventListener("click", function () {

        const type =
            password.getAttribute("type") === "password"
                ? "text"
                : "password";

        password.setAttribute("type", type);

        icon.classList.toggle("bi-eye-fill");
        icon.classList.toggle("bi-eye-slash-fill");

    });

}