document.addEventListener("DOMContentLoaded", function() {
    const detailsHeader = document.querySelector(".details-header");
    const detailsContent = document.querySelector(".details-content");

    detailsHeader.addEventListener("click", function() {
        const display = detailsContent.style.display;

        if (display === "none") {
            detailsContent.style.display = "block";
        } else {
            detailsContent.style.display = "none";
        }
    });
});