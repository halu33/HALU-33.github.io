document.addEventListener("DOMContentLoaded", function() {
    const detailsHeader = document.querySelector("#detailsHeader");
    const detailsContent = document.querySelector("#detailsContent");

    detailsHeader.addEventListener("click", function() {
        const display = detailsContent.style.display;

        if (display === "none") {
            detailsContent.style.display = "block";
        } else {
            detailsContent.style.display = "none";
        }
    });
});