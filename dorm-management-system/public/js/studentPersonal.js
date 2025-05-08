//
//     document.addEventListener('DOMContentLoaded', function() {
//     showNews();
//     @if(session('successType') === 'profile_updated')
//     showPersonal();
//     @elseif(session('successType') === 'request_updated')
//     openRequestList();
//     @elseif(session('successType') === 'request_created')
//     openRequestList();
//     @elseif(session('successType') === 'gym_created')
//     showSportsBooking();
//     @elseif(session('successType') === 'gym_canceled')
//     showSportsBooking();
//     @elseif(session('successType') === 'recovery_created')
//     showSportsBooking();
//     @elseif(session('successType') === 'recovery_canceled')
//     showSportsBooking();
//     @elseif(session('successType') === 'change_room_created')
//     showHousing();
//     @elseif(session('successType') === 'user_updated')
//     showHousing()
//     @elseif(session('successType') === 'document_uploaded')
//     showDocuments();
//     @endif
// });
//     function showPersonal() {
//     hideAllSections()
//     document.getElementById('personal-section').style.display = 'block';
// }
//     function openPasswordModal() {
//     document.getElementById('passwordModal').style.display = 'flex';
// }
//     function closePasswordModal() {
//     document.getElementById('passwordModal').style.display = 'none';
// }
//     function showHousing() {
//     hideAllSections()
//     document.getElementById('housing-section').style.display = 'block';
// }
//     function openChangeRoomModal() {
//     document.getElementById('changeRoomModal').style.display = 'flex';
// }
//     function closeChangeRoomModal() {
//     document.getElementById('changeRoomModal').style.display = 'none';
// }
//     document.addEventListener('DOMContentLoaded', function() {
//     const buildingSelect = document.getElementById('buildingSelect');
//     const floorSelect = document.getElementById('floorSelect');
//     const roomSelect = document.getElementById('roomSelect');
//
//     buildingSelect.addEventListener('change', async function() {
//     const buildingId = this.value;
//     floorSelect.disabled = true;
//     roomSelect.disabled = true;
//     floorSelect.innerHTML = '<option>Загрузка...</option>';
//     roomSelect.innerHTML = '<option>Сначала выберите этаж</option>';
//
//     if (!buildingId) return;
//
//     const response = await fetch(`/student/personal/floors/${buildingId}`);
//     const floors = await response.json();
//
//     if (!floors || floors.length === 0) {
//     floorSelect.innerHTML = '<option>Нет доступных этажей</option>';
//     return;
// }
//
//     floorSelect.innerHTML = '<option value="">Выберите этаж</option>';
//     floors.forEach(f => {
//     floorSelect.innerHTML += `<option value="${f}">${f}</option>`;
// });
//     floorSelect.disabled = false;
// });
//
//     floorSelect.addEventListener('change', async function() {
//     const buildingId = buildingSelect.value;
//     const floor = this.value;
//     roomSelect.disabled = true;
//     roomSelect.innerHTML = '<option>Загрузка...</option>';
//
//     if (!floor) return;
//
//     const response = await fetch(`/student/personal/rooms/${buildingId}/${floor}`);
//     const rooms = await response.json();
//
//     if (!rooms || rooms.length === 0) {
//     roomSelect.innerHTML = '<option>Нет доступных комнат</option>';
//     return;
// }
//
//     roomSelect.innerHTML = '<option value="">Выберите комнату</option>';
//     rooms.forEach(r => {
//     roomSelect.innerHTML += `<option value="${r.id}">${r.room_number}</option>`;
// });
//     roomSelect.disabled = false;
// });
//     console.log("DOM полностью загружен");
// });
//     function showDocuments() {
//     hideAllSections();
//     document.getElementById('documents-section').style.display = 'block';
// }
//
//     // Добавьте функцию показа финансового раздела
//     function showFinance() {
//     hideAllSections();
//     document.getElementById('financeSection').style.display = 'block';
// }
//
//     document.getElementById('kaspiPaymentForm').addEventListener('submit', async function(e) {
//     e.preventDefault();
//
//     try {
//     const response = await fetch('/student/payment/initiate', {
//     method: 'POST',
//     headers: {
//     'Content-Type': 'application/json',
//     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
// },
//     body: JSON.stringify({
//     amount: document.getElementById('amount').value
// })
// });
//
//     const result = await response.json();
//
//     if (result.success && result.payment_url) {
//     window.location.href = result.payment_url;
// } else {
//     alert(result.message || 'Ошибка при создании платежа');
// }
// } catch (error) {
//     console.error('Payment error:', error);
//     alert('Произошла ошибка при обработке платежа');
// }
// });
//
//     document.getElementById('uploadButton').addEventListener('click', function () {
//     document.getElementById('uploadForm').style.display = 'block';
// });
//     document.getElementById('cancelUpload').addEventListener('click', function () {
//     document.getElementById('uploadForm').style.display = 'none';
// });
//     function showRequestRepair() {
//     hideAllSections();
//     document.getElementById('repair-list').style.display = 'block';
// }
//     function openRequestDetails(id) {
//     hideAllSections();
//     document.getElementById('request-details-' + id).style.display = 'block';
// }
//     function closeRequestDetails(id) {
//     document.getElementById('request-details-' + id).style.display = 'none';
//     document.getElementById('request-list').style.display = 'block';
// }
//     function openRequestList() {
//     hideAllSections();
//     document.getElementById('request-list').style.display = 'block';
// }
//     function closeRequestList() {
//     document.getElementById('request-list').style.display = 'none';
//     document.getElementById('repair-list').style.display = 'block';
// }
//     function openRepairModal() {
//     document.getElementById('repairModal').style.display = 'flex';
// }
//     function closeRepairModal() {
//     document.getElementById('repairModal').style.display = 'none';
// }
//     function openEditModal(id) {
//     document.getElementById('edit-modal-' + id).style.display = 'flex';
// }
//     function closeEditModal(id) {
//     document.getElementById('edit-modal-' + id).style.display = 'none';
// }
//     document.getElementById("file-upload").addEventListener("change", function () {
//     let fileName = this.files[0] ? this.files[0].name : "Не выбрано";
//     document.getElementById("file-label").textContent = `📎 ${fileName}`;
// });
//     function showSportsBooking() {
//     hideAllSections();
//     document.getElementById('sports-section').style.display = 'block';
// }
//     function cancelSportsForm() {
//     document.getElementById('sport').value = '';
//     document.getElementById('time').value = '';
//     const checkboxes = document.querySelectorAll('#day-selection input[type="checkbox"]');
//     checkboxes.forEach(cb => cb.checked = false);
// }
//     function showRecoveryModal() {
//     document.getElementById('recoveryModal').style.display = 'flex';
// }
//     function closeRecoveryModal() {
//     document.getElementById('recoveryModal').style.display = 'none';
// }
//     function hideAllSections() {
//     document.getElementById('see-news-section').style.display = 'none';
//     document.getElementById('personal-section').style.display = 'none';
//     document.getElementById('housing-section').style.display = 'none';
//     document.getElementById('documents-section').style.display='none';
//     document.getElementById('financeSection').style.display = 'none';
//     document.getElementById('repair-list').style.display = 'none';
//     document.getElementById('request-list').style.display = 'none';
//     document.getElementById('repairModal').style.display = 'none';
//     document.getElementById('sports-section').style.display = 'none';
//     @foreach($requests as $request)
//     document.getElementById('edit-modal-{{ $request->id }}').style.display = 'none';
//     @endforeach
// }
