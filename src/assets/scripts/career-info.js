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