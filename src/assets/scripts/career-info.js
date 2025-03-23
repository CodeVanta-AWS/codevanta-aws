function openModal(id, name, description) {
    document.getElementById('modal').style.display = 'block';
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_description').value = description;
}
function closeModal() {
    document.getElementById('modal').style.display = 'none';
}
function openDeleteModal(id) {
    document.getElementById('deleteModal').style.display = 'block';
    document.getElementById('delete_id').value = id;
}
function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

// document.addEventListener("DOMContentLoaded", function () {
//     const searchInput = document.querySelector("input[placeholder='Search data']");

//     searchInput.addEventListener("input", function () {
//         const searchValue = searchInput.value.trim();

//         fetch(`career-info.php?search=${encodeURIComponent(searchValue)}`)
//             .then(response => response.text())
//             .then(html => {
//                 const parser = new DOMParser();
//                 const doc = parser.parseFromString(html, "text/html");
//                 document.querySelector("table").innerHTML = doc.querySelector("table").innerHTML;
//             })
//             .catch(error => console.error("Error fetching search results:", error));
//     });
// });